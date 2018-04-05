var sessions = null;
var soundPlayer = null;
var selfView = null;
var remoteView = null;

var on_accepted = function() {};
var on_ended = function() {};
var on_denied = function() {};
var on_popup = function() {};
var on_loggedin = function() {};
var on_login_failed = function() {};
var on_disconnected = function() {};

var ua = null;

$(document).ready(function() {
	
	JsSIP.debug.disable('JsSIP:*');
	
	if (window.rtcninjaTemasys) { 
		rtcninjaTemasys(
			{}, 
			function() { JsSIP.rtcninja({plugin: rtcninjaTemasys}); }, 
			function(data) { alert('WebRTC plugin required !!'); }, 
			null
		); 
	}
	
	soundPlayer = document.createElement("audio");
	soundPlayer.volume = 1;
	sessions = document.createElement('div');
	sessions.id = "sessions";
	document.body.appendChild(sessions);
	selfView = document.createElement('video');
	selfView.muted = true;
	selfView.autoplay = true;
	remoteView = document.createElement('video');
	remoteView.autoplay = true;
	
	var localStream, remoteStream;
	var localCanRenegotiateRTC = function() { 
		return JsSIP.rtcninja.canRenegotiate; 
	};
	
	function phoneInit(ws_server, sip_uri, sip_password) {
		var configuration = {  
				uri: sip_uri, 
				password: sip_password, 
				ws_servers: ws_server, 
				display_name: null, 
				authorization_user: null, 
				register: true, 
				register_expires: 600, 
				registrar_server: null, 
				no_answer_timeout: 60, 
				session_timers: false, 
				use_preloaded_route: false, 
				connection_recovery_min_interval: 2, 
				connection_recovery_max_interval: 30, 
				hack_via_tcp: false, 
				hack_via_ws: false, 
				hack_ip_in_contact: false 
		};
		
		try { 
			ua = new JsSIP.UA(configuration); // *****
		} catch (e) { 
			console.log(e.toString()); 
			//alert();
			return; 
		}
		
		//
		ua.on('connected', function(e) { 
			INSTANCE.is_online = false; 
		});
		
		ua.on('disconnected', function(e) { 
			$("#sessions > .session").each(function(i, session) { 
				INSTANCE.removeSession(session, 500); 
			}); 
			INSTANCE.is_online = false; 
			on_disconnected(); 
		});
	
		ua.on('newRTCSession', function(e) { 
			INSTANCE.new_session(e); 
		});
		
		ua.on('registered', function(e) { 
			INSTANCE.is_online = true; 
			on_loggedin(); 
		});
		
		ua.on('unregistered', function(e) { 
			INSTANCE.is_online = false; 
		});
		
		ua.on('registrationFailed', function(e) { 
			INSTANCE.is_online = false; 
			on_login_failed(); 
		});
		
		// #####
		ua.start();
	}
	
	
	//  ###### ###### ###### ###### ###### ###### ###### ######
	window.INSTANCE = {
		is_online: false, 
		direction: "",
		display_name: "",
		
		// = = = = = = = = = = = = = = = = = = = = = = = = = = =
		login : function(ws_server, sip_uri, sip_password) {
			try { 
				phoneInit(ws_server, sip_uri, sip_password); 
			} catch (err) {
				console.warn(err.toString()); 
			}
		},
		
		// = = = = = = = = = = = = = = = = = = = = = = = = = = =
		re_login : function() {
			
			//ua.unregister();
			//ua.register();
			
			alert('111');
		},
		
		// = = = = = = = = = = = = = = = = = = = = = = = = = = =
		unregister : function() {
			
			//ua.unregister();
			
			alert('unregister');
		},
		
		// = = = = = = = = = = = = = = = = = = = = = = = = = = =
		clean : function() {
			INSTANCE.direction = "";
			INSTANCE.uri = null; 
		},
		
		// = = = = = = = = = = = = = = = = = = = = = = = = = = = 
	    new_session : function(e) {
			var request = e.request;
			var call = e.session;
			var uri = call.remote_identity.uri.toString();
			var session = INSTANCE.getSession(uri);
			var status;
			var display_name = call.remote_identity.display_name || call.remote_identity.uri.user;



                INSTANCE.direction = call.direction;
			INSTANCE.display_name = display_name;
	
			if (call.direction === 'incoming') {
				status = "incoming";
				if (request.getHeader('X-Can-Renegotiate') === 'false') {
					call.data.remoteCanRenegotiateRTC = false;
				} else {
					call.data.remoteCanRenegotiateRTC = true;
				}
			} else {
				status = "trying";
			}
	
	      	if (session && !$(session).find(".call").hasClass("inactive")) {
	      		call.terminate();
	      		return false;
	      	}
	      	
	      	on_popup();
	      	if (!session) {
	      		session = INSTANCE.createSession(display_name, uri, call.direction);
	      	}
            session.phone_number = display_name;
            //console.log(session.phone_number);

	      	session.call = call;
	      	INSTANCE.setCallSessionStatus(session, status);
	
	      	call.on('connecting', function() {
		        if (call.connection.getLocalStreams().length > 0) {
		        	window.localStream = call.connection.getLocalStreams()[0];
		        }
	      	});
	      	
	      	call.on('progress',function(e) {
		        if (e.originator === 'remote') {
		          INSTANCE.setCallSessionStatus(session, 'in-progress');

                    soundPlayer.loop = true;
                    soundPlayer.setAttribute("src", "sounds/outgoing-call.ogg");
                    soundPlayer.play();
		        }
	      	});
	      	
	      	call.on('accepted',function(e) {

		        if (call.connection.getLocalStreams().length > 0) {
		          localStream = call.connection.getLocalStreams()[0];
		          selfView = JsSIP.rtcninja.attachMediaStream(selfView, localStream);
		          selfView.volume = 0;
		
		          window.localStream = localStream;
		        }
		
		        if (e.originator === 'remote') {
		          if (e.response.getHeader('X-Can-Renegotiate') === 'false') {
		            call.data.remoteCanRenegotiateRTC = false;
		          }
		          else {
		            call.data.remoteCanRenegotiateRTC = true;
		          }
		        }

		        INSTANCE.setCallSessionStatus(session, 'answered');
                soundPlayer.loop = false;
		        on_accepted();
	      	});
	      	
	      	call.on('addstream', function(e) {
		        remoteStream = e.stream;
		        remoteView = JsSIP.rtcninja.attachMediaStream(remoteView, remoteStream);
	      	});
	      	
	      	call.on('failed',function(e) {
		        var cause = e.cause;
		        var response = e.response;
		        on_denied();
		        if (e.originator === 'remote' && cause.match("SIP;cause=200", "i")) { cause = 'answered_elsewhere'; }
		        INSTANCE.setCallSessionStatus(session, 'terminated', cause);
		        soundPlayer.setAttribute("src", "sounds/outgoing-call-rejected.wav");
		        soundPlayer.play();
                soundPlayer.loop = false;
		        INSTANCE.removeSession(session, 900);
		        selfView.src = '';
		        remoteView.src = '';
	      	});
	      	
	      	call.on('hold',function(e) {
		        soundPlayer.setAttribute("src", "sounds/dialpad/pound.ogg");
		        soundPlayer.play();
		        INSTANCE.setCallSessionStatus(session, 'hold', e.originator);
	      	});
	      	
	      	call.on('unhold',function(e) {
		        soundPlayer.setAttribute("src", "sounds/dialpad/pound.ogg");
		        soundPlayer.play();
		        INSTANCE.setCallSessionStatus(session, 'unhold', e.originator);
	      	});
	      	
	      	call.on('ended', function(e) {
		        var cause = e.cause;
		        on_ended();
		        INSTANCE.setCallSessionStatus(session, "terminated", cause);
		        INSTANCE.removeSession(session, 900);
		        selfView.src = '';
		        remoteView.src = '';
		        JsSIP.rtcninja.closeMediaStream(localStream);
	      	});
	      	
	      	call.on('update', function(e) {
		        var request = e.request;
		        if (! request.body) { return; }
		        if (! localCanRenegotiateRTC() || ! call.data.remoteCanRenegotiateRTC) {
		          call.connection.reset();
		          call.connection.addStream(localStream);
		        }
	      	});
	      	
	      	call.on('reinvite', function(e) {
		        var request = e.request;
		        if (! request.body) { return; }
		        if (! localCanRenegotiateRTC() || ! call.data.remoteCanRenegotiateRTC) {
		        	call.connection.reset();
		        	call.connection.addStream(localStream);
		        }
	      	});
	    },
	    
	    // = = = = = = = = = = = = = = = = = = = = = = = = = = = 
		getSession : function(uri) {
			var session_found = null;
	
			$("#sessions > .session").each(function(i, session) {
				if (uri === $(this).find(".peer > .uri").text()) {
					session_found = session;
					return false;
				}
			});
	
			if (session_found)
				return session_found;
			else
				return false;
	    },
	    
	    // = = = = = = = = = = = = = = = = = = = = = = = = = = = 
	    createSession : function(display_name, uri, direction) {
	    	var session_div = $('\
			      <div class="session effect8"> \
			        <div class="close"></div> \
			        <div class="container_call"> \
	    			  <div class="call inactive"> \
	    			<div class="button dial"></div><div class="button hold"></div><div class="button hangup"></div><div class="button resume"></div><div class="direction">' + direction + '</div> \
			          </div> \
			          <div class="peer"> \
			            <span class="display-name">' + display_name + '</span> \
			          </div> \
			          <div class="call-status"></div> \
			        </div> \
			      </div> \
	    	');
	
	      	$("#sessions").append(session_div);
	
	      	var session = $("#sessions .session").filter(":last");
	      	var call_status = $(session).find(".call");
	      	var close = $(session).find("> .close");



	  		$(session).hover(function() {
	  			if ($(call_status).hasClass("inactive"))
	  				$(close).show();
	  		}, function() {
	  			$(close).hide();
	  		});
	
	      	close.click(function() {
	      		INSTANCE.removeSession(session, null, true);
	      	});
	
	      	$(session).fadeIn(100);
	      	return session;
	    },
	    
	    // = = = = = = = = = = = = = = = = = = = = = = = = = = = 
	    setCallSessionStatus : function(session, status, description, realHack) {
	    	var session = session;


	    	var uri = $(session).find(".peer > .uri").text();
	    	var call = $(session).find(".call");

	    	
	    	var status_text = $(session).find(".call-status");
	    	
	    	var button_dial = $(session).find(".button.dial");
	    	var button_hangup = $(session).find(".button.hangup");
	    	var button_hold = $(session).find(".button.hold");
	    	var button_resume = $(session).find(".button.resume");


	    	if (status != "inactive" && status != "terminated") {
	    	    $(session).unbind("hover");
	    	    $(session).find("> .close").hide();
	    	}
	
	    	button_dial.unbind("click");
	    	button_hangup.unbind("click");
	    	button_hold.unbind("click");
	    	button_resume.unbind("click");
	
	    	if (session.call && session.call.status !== JsSIP.C.SESSION_TERMINATED) {
	    	    button_hangup.click(function() {
	    	        INSTANCE.setCallSessionStatus(session, "terminated", "terminated");
	    	        session.call.terminate();
	    	        INSTANCE.removeSession(session, 500);
	    	    });
	    	}

	    	switch(status) {
		    	case "inactive":
		    	    call.removeClass();
		    	    call.addClass("call inactive");
		    	    status_text.text("");
                    button_dial.click(function() {
                        INSTANCE.call(uri);

                    });
		    	    break;
		
		    	case "trying":
		    	    call.removeClass();
		    	    call.addClass("call trying");
		    	    status_text.text(description || "trying...");
		    	    break;
		
		    	case "in-progress":
		    	    call.removeClass();
		    	    call.addClass("call in-progress");
		    	    status_text.text(description || "in progress...");
		    	    soundPlayer.setAttribute("src", "sounds/outgoing-call.ogg");
		    	    soundPlayer.play();

		    	    break;
		
		    	case "answered":
		    	    call.removeClass();
		    	    call.addClass("call answered");
		    	    status_text.text(description || "Đã kết nối");
		    	    button_hold.click(function(){
		    	        if (! session.call.isReadyToReOffer()) { return; }
		    	        if (! localCanRenegotiateRTC() || ! session.call.data.remoteCanRenegotiateRTC) {
		    	            session.call.connection.reset();
		    	            session.call.connection.addStream(localStream);
		    	        }
		    	        session.call.hold({useUpdate: false});
		    	    });
		    	    if (realHack) { return; }
		    	    break;
		
		    	case "hold":
		    	case "unhold":
		    	    if (session.call.isOnHold().local) {
		    	        call.removeClass();
		    	        call.addClass("call on-hold");
		    	        button_resume.click(function(){
		    	            if (! session.call.isReadyToReOffer()) { return; }
		    	            if (! localCanRenegotiateRTC() || ! session.call.data.remoteCanRenegotiateRTC) {
		    	                session.call.connection.reset();
		    	                session.call.connection.addStream(localStream);
		    	            }
		    	            session.call.unhold();
		    	        });
		    	    } else {
		    	        INSTANCE.setCallSessionStatus(session, 'answered', null, true);
		    	    }
		
		    	    var local_hold = session.call.isOnHold().local;
		    	    var remote_hold = session.call.isOnHold().remote;
		
		    	    var status = "Giữ máy";
		    	    status += local_hold?" local ":"";
		    	    if (remote_hold) {
		    	        if (local_hold)  status += "/";
		    	        status += " remote";
		    	    }
		    	    if (local_hold||remote_hold) {
		    	    	status_text.text(status); 
		    	    }
		    	    break;
		
		    	case "terminated":
		    	    call.removeClass();
		    	    call.addClass("call terminated");
		    	    status_text.text(description || "terminated");
		    	    button_hangup.unbind("click");
		    	    break;
		
		    	case "incoming":
		    	    call.removeClass();
		    	    call.addClass("call incoming");
		    	    status_text.text("Đang gọi...");

		    	    soundPlayer.setAttribute("src", "sounds/incoming-call.ogg");
                    soundPlayer.play();
                    var checkExitSession = session.prevObject.length;
                    if(checkExitSession < 2){  // Check nếu như đã có cuộc gọi rồi thì không gọi play sound nữa
                        soundPlayer.loop = true;
                    }


		    	    button_dial.click(function() {
		    	        session.call.answer({
		    	            pcConfig: "{}",
		    	            mediaConstraints: {audio: true, video: false},
		    	            extraHeaders: [ 'X-Can-Renegotiate: ' + String(localCanRenegotiateRTC()) ],
		    	            rtcOfferConstraints: { offerToReceiveAudio: 1, offerToReceiveVideo: 1 }
		    	        });
                        console.log('So dien thoai:' + session.phone_number);
                        //console.log('usser name '+ INSTANCE);
                        var win = window.open('index.php?r=orderonlinelog/creatorder&id='+ session.phone_number , '_blank');
                        win.focus();

		    	    });
		    	    break;
		
		    	default:
		    	    alert("ERROR: setCallSessionStatus() called with unknown status '" + status + "'");
		    	    break;
	    	}
	    },
	    
	    // = = = = = = = = = = = = = = = = = = = = = = = = = = = 
	    removeSession : function(session, time, force) {
	    	$(session).slideUp(800, function() { $(session).remove(); });
	    },
	    
	    // = = = = = = = = = = = = = = = = = = = = = = = = = = = 
	    setDelayedCallSessionStatus : function(uri, status, description, force) {
	    	var session = INSTANCE.getSession(uri.toString());
	    	if (session) {
	    		INSTANCE.setCallSessionStatus(session, status, description, force);
	    	}
	    },
	    
	    // = = = = = = = = = = = = = = = = = = = = = = = = = = = 
	    call : function(target) {
	        ua.call(target, {
	            pcConfig: "{}",
	            mediaConstraints: { audio: true, video: false },
	            extraHeaders: [ 'X-Can-Renegotiate: ' + String(localCanRenegotiateRTC()) ],
	            rtcOfferConstraints: { offerToReceiveAudio: 1, offerToReceiveVideo: 1 }
	        });
	    }
	};
});
