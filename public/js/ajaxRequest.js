											/*	Register Screen	 */
///Form Register
function formRegister(){
	let hidden = document.getElementById('divLogin');
	let show = document.getElementById('divRegister');

	if (show.style.display == 'block') {
		show.style.display = 'none';
		hidden.style.display = 'block';

	}else{
		show.style.display = 'block';
		hidden.style.display = 'none';
	}
}

//Load File
$(document).ready(function() {
	//Preview Img Profile
	$("#fileProfile").change( function(event) {
		event.preventDefault();
		var file = document.getElementById('fileProfile').files[0];
	    var reader  = new FileReader();
	    // it's onload event and you forgot (parameters)
	    $(".login-spinner").addClass('spinner');
	    reader.onload = function(e)  {
	        $("#imgProfile").attr('src', reader.result);
	        $(".login-spinner").removeClass('spinner');
	     }
	     // you have to declare the file loading
	     reader.readAsDataURL(file);
	});
});

//Register
$(document).ready(function() {
	$("#register").submit(function (e) {
	e.preventDefault();

    	const Toast = Swal.mixin({
		  toast: true,
		  position: 'top-end',
		  showConfirmButton: false,
		  timer: 3000,
		  timerProgressBar: true,
		  didOpen: (toast) => {
		    toast.addEventListener('mouseenter', Swal.stopTimer)
		    toast.addEventListener('mouseleave', Swal.resumeTimer)
		  }
		});

    	$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN' : $("meta[name='csrf-token']").attr('content')
			}
		});


		var formData = new FormData(this);
		

		//Spinner Loading
		var spin = document.getElementById('spin2');
		spin.style.visibility = 'visible';

		$("button").attr('disabled', 'disabled');
        
        $.ajax({
            type: 'POST',
            url: '/register',
            data: formData,
            dataType: 'json',
            processData: false,  
		   	contentType: false,
		   	cache : false,
            success: function(data){

                if (data[0] == 1) {
					Toast.fire({
						icon: 'success',
						text: 'Cadastro feito com sucesso!'
					});

					formRegister();
					$("#imgProfile").attr('src', '/img/profile.png');
					$(".inputRegister").val("");
					$("input[type='checkbox']").prop('checked', false);

				}else{
					Toast.fire({
						icon: 'info',
						text: 'Existe um usuário com email já cadastrado!'
					});
				}

				spin.style.visibility = 'hidden';
				$("button").removeAttr('disabled', 'disabled');

            },

            error: function(data){
                Swal.fire({
                    icon: 'error',
                    text: 'Erro ao tentar conexão!'
                });

                spin.style.visibility = 'hidden';
				$("button").removeAttr('disabled', 'disabled');
            }
        });          
	});
});

											/*	Login Screen	 */
//Login
$(document).ready(function(){
	$("#login").submit(function (e) {
		e.preventDefault();

		const Toast = Swal.mixin({
		  toast: true,
		  position: 'top-end',
		  showConfirmButton: false,
		  timer: 3000,
		  timerProgressBar: true,
		  didOpen: (toast) => {
		    toast.addEventListener('mouseenter', Swal.stopTimer)
		    toast.addEventListener('mouseleave', Swal.resumeTimer)
		  }
		});

		//Spinner Loading
		var spin = document.getElementById('spin');
		spin.style.visibility = 'visible';

		$("button").attr('disabled', 'disabled');

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN' : $("meta[name='csrf-token']").attr('content')
			}
		});
		
		$.ajax({
			type: "POST",
			url: "/login",
			data: $(this).serialize(),
			dataType: 'json',
			success: function(data){
				if (data[0] == 1) {
					window.location.href="/home";
				}else{
				    if(data[0]  == 2){
				    	Swal.fire({ 
						    icon: 'info',
						    text: 'Sua conta foi suspensa, entre em contato com ADM!', 
						});
						
						spin.style.visibility = 'hidden';
						$("button").removeAttr('disabled', 'disabled');
				    }else{
				    	Toast.fire({
							icon: 'error',
							text: 'Email ou senha inválida!'
						});
						
						spin.style.visibility = 'hidden';
						$("button").removeAttr('disabled', 'disabled');
				    }
				}
			},
			error:function(argument) {
				Toast.fire({
					icon: 'error',
					text: 'Erro ao tentar conexão!'
				});

				spin.style.visibility = 'hidden';
				$("button").removeAttr('disabled', 'disabled');
			}
			
		});
	})
});

/*===========================================================================================================*/
											/*	Profile	 */
//Data User
$(document).ready(function(){
	$.ajax({
		type: 'GET',
		url: '/dataUser',
		dataType: 'json',
		success:function(data){
			var photo = data[0];
			var name = data[1];
			var email = data[2];

			if (!photo) {
				$("#imgMessage").attr('src', '/img/profile.png');
				$("#imgProfiles").attr('src', '/img/profile.png');
			}else{
				$("#imgMessage").attr('src', '/img/profile/'+photo);
				$("#imgProfiles").attr('src', '/img/profile/'+photo);
			}

			//$("#nameProfileHome").text(name);
		}
	});
});

//Edit User
function showProfile(){

	$(".add-spinner").addClass('spinner');
	$(".bg-loading").addClass('opacity-loading');

	$(document).ready(function(){
		$.ajax({
			type: 'GET',
			url: '/dataUser',
			dataType: 'json',
			success:function(data){
				var photo = data[0];
				var name = data[1];
				var email = data[2];

				formEditProfile(photo,name,email);

				$(".add-spinner").removeClass('spinner');
				$(".bg-loading").removeClass('opacity-loading');
			},
			error:function(data) {
				Toast.fire({
					icon: 'error',
					text: 'Erro ao tentar conexão!'
				});
				$(".add-spinner").removeClass('spinner');
				$(".bg-loading").removeClass('opacity-loading');
			}
		});

	});

}

//Form Edit Profile
function formEditProfile(photo,name,email){
	if (!photo) {
		var photoPath = 'profile.png';
	}else{
		var photoPath = 'profile/'+photo;
	}


	Swal.fire({
	  	cancelButtonText: 'Cancelar',
	    showCancelButton: true,
	    confirmButtonColor: '#3085d6',
	    cancelButtonColor: '#d33',
	    confirmButtonText: 'Salvar',
		html:
	        '<div class="profile-userpic">'+
                '<label id="labelProfile" for="fileEdit">'+
                '<img src="/img/'+photoPath+'" id="imgEditProfile" class="img-responsive" alt=""></label>'+
            	'<input type="file" class="disabilitar" name="fileEdit" id="fileEdit" accept=".png, .jpeg, .jpg" required>'+
            '</div><br>'+
	        '<input type="text" class="form-control" id="nameEdit" placeholder="Nome" value="'+name+'"><br>'+
	        '<input type="text" class="form-control" id="emailEdit" placeholder="Email" value="'+email+'"><br>',
	}).then((result) => {

        if (result.isConfirmed) {
        
			if ($("#nameEdit").val() == "" || $("#emailEdit").val() == "") {
			  Swal.fire({ 
			      icon: 'info',
			      text: 'Precisa preencher os campos!', 
			  }).then((result) => {
			        showProfile();
			  });
			}else{
				var photo = $('#fileEdit').prop('files')[0];
			    var name = $("#nameEdit").val();
			    var email = $("#emailEdit").val();
			    
			    Swal.fire({
			        icon: 'question',
			        text: 'Salvar alterações?',
			        cancelButtonText: 'Não',
			        showCancelButton: true,
			        confirmButtonColor: '#3085d6',
			        cancelButtonColor: '#d33',
			        confirmButtonText: 'Sim',
			    }).then((result) =>{
			        if (result.isConfirmed) {

			        	const Toast = Swal.mixin({
						  toast: true,
						  position: 'top-end',
						  showConfirmButton: false,
						  timer: 3000,
						  timerProgressBar: true,
						  didOpen: (toast) => {
						    toast.addEventListener('mouseenter', Swal.stopTimer)
						    toast.addEventListener('mouseleave', Swal.resumeTimer)
						  }
						});

			        	$.ajaxSetup({
							headers: {
								'X-CSRF-TOKEN' : $("meta[name='csrf-token']").attr('content')
							}
						});
						var formData = new FormData();
						formData.append("photo", photo);
						formData.append("name", name);
						formData.append("email" , email);

						$(".add-spinner").addClass('spinner');
						$(".bg-loading").addClass('opacity-loading');
			            
			            $.ajax({
			                type: 'POST',
			                url: '/updateUser',
			                data: formData,
			                dataType: 'json',
			                processData: false,  
						   	contentType: false,
						   	cache : false,
			                success: function(data){

			                    if (data[0] == 1) {
									Toast.fire({
										icon: 'success',
										text: 'Alteração feita!'
									});

									$.ajax({
										type: 'GET',
										url: '/dataUser',
										dataType: 'json',
										success:function(data){
											var photo = data[0];
											var name = data[1];
											var email = data[2];

											if (!photo) {
												//$("#imgProfileHome").attr('src', '/img/profile.png');
												$("#imgProfiles").attr('src', '/img/profile.png');
											}else{
												//$("#imgProfileHome").attr('src', '/img/profile/'+photo);
												$("#imgProfiles").attr('src', '/img/profile/'+photo);
											}
											//$("#nameProfileHome").text(name);
										}
									});
								}else{
									Toast.fire({
										icon: 'error',
										text: 'Algo deu errado!'
									});
								}

								$(".add-spinner").removeClass('spinner');
								$(".bg-loading").removeClass('opacity-loading');

			                },

			                error: function(data){
			                    Swal.fire({
			                        icon: 'error',
			                        text: 'Erro ao tentar conexão!'
			                    });
			                }
			            });
			        }
			    });
              
          	}
        }
    });

	//Preview Img Profile
	$("#fileEdit").change( function(event) {
		event.preventDefault();
		var file = document.getElementById('fileEdit').files[0];
	    var reader  = new FileReader();
	    // it's onload event and you forgot (parameters)
	    $(".add-spinner").addClass('spinner');
	    reader.onload = function(e)  {
	        $("#imgEditProfile").attr('src', reader.result);
	        $(".add-spinner").removeClass('spinner');
	     }
	     // you have to declare the file loading
	     reader.readAsDataURL(file);
	});
}

/*===========================================================================================================*/
											/*	Home	 */

//Show Users
$(document).ready(function(){
	$(".add-spinner").addClass('spinner');
	$(".bg-loading").addClass('opacity-loading');
	$.ajax({
		type: 'GET',
		url: '/showUsers',
		success:function(data){
			$(".list-unstyled").html(data);

			$(".add-spinner").removeClass('spinner');
			$(".bg-loading").removeClass('opacity-loading');
		}
	});
});

//Show Screen Messages
function showScreenMessages(id){
	let iconLogo = document.getElementById('iconLogo');
	let screenMessages = document.getElementById('screenMessages');
	let inputMessage = document.getElementById('inputMessage');

	if (!$(".li-bg").hasClass('bg-selected')) {
		if (!$("#selected_"+id).hasClass('bg-selected')) {
			$("#selected_"+id).addClass('bg-selected');

			$(".add-spinner").addClass('spinner');
			$(".bg-loading").addClass('opacity-loading');

			showMessages(id);
			$(".messages").html("");
			screenMessages.style.display = 'block';
			iconLogo.style.display = 'none';
			idSave = id;

			//Show Input Message
			inputMessage.style.display = 'block';
		}

	}else{
		if (!$("#selected_"+id).hasClass('bg-selected')) {
			$(".li-bg").removeClass('bg-selected');
			$("#selected_"+id).addClass('bg-selected');

			$(".add-spinner").addClass('spinner');
			$(".bg-loading").addClass('opacity-loading');

			showMessages(id);
			$(".messages").html("");
			screenMessages.style.display = 'block';
			iconLogo.style.display = 'none';
			idSave = id;

			//Show Input Message
			inputMessage.style.display = 'block';
		}else{
			$("#selected_"+id).removeClass('bg-selected');
			screenMessages.style.display = 'none';
			iconLogo.style.display = 'block';
			idSave = "";

			//Hidden Input Message
			inputMessage.style.display = 'none';
		}

	}

}

var idSave;

//Show Messages
function showMessages(id) {
	$(document).ready(function(){
		
		const Toast = Swal.mixin({
		  toast: true,
		  position: 'top-end',
		  showConfirmButton: false,
		  timer: 3000,
		  timerProgressBar: true,
		  didOpen: (toast) => {
		    toast.addEventListener('mouseenter', Swal.stopTimer)
		    toast.addEventListener('mouseleave', Swal.resumeTimer)
		  }
		});

		$.ajax({
			type: 'GET',
			url: '/showMessages',
			data: {
				user_id: id,
			},
			success:function(data){
				$(".messages").html(data);
				$('.messages').animate({scrollTop: 9999999}, 500);

				$(".add-spinner").removeClass('spinner');
				$(".bg-loading").removeClass('opacity-loading');
			},
			error:function(data) {
				Toast.fire({
					icon: 'error',
					text: 'Algo deu errado!'
				});
			}
		});
	});
}

//Disabled btnMessage
$(document).keypress(function(e) {
	if(idSave && e.which === 13){
		sendMessage();
	}
});

//Send Message
function sendMessage(){

	if ($("#message").val() != "") {
		
		const Toast = Swal.mixin({
		  toast: true,
		  position: 'top-end',
		  showConfirmButton: false,
		  timer: 3000,
		  timerProgressBar: true,
		  didOpen: (toast) => {
		    toast.addEventListener('mouseenter', Swal.stopTimer)
		    toast.addEventListener('mouseleave', Swal.resumeTimer)
		  }
		});

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN' : $("meta[name='csrf-token']").attr('content')
			}
		});

		$.ajax({
			type: 'POST',
			url: '/sendMessage',
			data: {
				user_id: idSave,
				message: $("#message").val(),
			},
			//dataType: 'json',
			success:function(data){
				$.ajax({
					type: 'GET',
					url: '/showMessages',
					data: {
						user_id: idSave,
					},
					success:function(data){
						$(".messages").html(data);
						$('.messages').animate({scrollTop: 9999999}, 500);
					},
					error:function(data) {
						Toast.fire({
							icon: 'error',
							text: 'Algo deu errado!'
						});
					}
				});
				$("#message").val("");
				$("#btnMessage").addClass('disabled');
			},
			error:function(data) {
				Toast.fire({
					icon: 'error',
					text: 'Algo deu errado!'
				});
			}
		});
	}
}

//Refresh chat if new message arrives
setInterval( function() {
	$(document).ready(function () {
		$.ajax({
			type: "GET",
			url: "/newMessage",
			dataType: 'json',
			success: function(data){
				var stts = data[0];

				if (stts === 1) {

					$.ajax({
						type: 'GET',
						url: '/showUsers',
						success:function(data){
							$(".list-unstyled").html(data);
							$("#selected_"+idSave).addClass('bg-selected');
						}
					});

					//Update Refresh
					updateRefresh();
				}
			}
		});

		$.ajax({
			type: 'GET',
			url: '/readMessage',
			data:{
				user_id: idSave,
			},
			dataType: 'json',
			success:function(data){
				var stts = data[0];

				if (stts === 1) {

					$.ajax({
						type: 'GET',
						url: '/showUsers',
						success:function(data){
							$(".list-unstyled").html(data);
							$("#selected_"+idSave).addClass('bg-selected');
						}
					});

					//Refresh Chat
					$.ajax({
						type: 'GET',
						url: '/showMessages',
						data: {
							user_id: idSave,
						},
						success:function(data){
							$(".messages").html(data);

							$('.messages').animate({scrollTop: 9999999}, 500);
						}
					});
				}
			}
		});	
	});
},5000);

//Update Refresh
function updateRefresh() {
	$(document).ready(function () {
		$.ajax({
			type: "GET",
			url: "/updateRefresh",
		});
	});
}

//Disabled btnMessage
$(document).ready(function() {
	$("#message").on('keyup',function(e) {
		e.preventDefault();

		var value = $(this).val();

		if (value != "") {
			$("#btnMessage").removeClass('disabled');
		}else{
			$("#btnMessage").addClass('disabled');
		}
	});
});
