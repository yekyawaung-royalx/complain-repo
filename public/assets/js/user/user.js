$(document).ready(function() {

    var url = $("#url").val();
    fetchstudent();

    function fetchstudent() {
        $.ajax({
            type: "GET",
            url: "/cx-team/list",
            dataType: "json",
            success: function(data) {
                //$('tbody').html("");
                if (data.total > 0) {
                    $.each(data.data, function(key, item) {
                        //console.log(response.users.data);
                        $("#fetched-data").append('<tr>' +
                            '<td class="img-content-box">' +
                            '<div class="media">' +
                            '<div class="square-box me-2"><img class="img-fluid b-r-5" src="https://admin.pixelstrap.com/zeta/assets/images/avtar/chinese.png" alt=""></div>' +
                            '<div class="media-body ps-2">' +
                            '<div class="avatar-details"><a href="product-page.html">' +
                            '<span>' + item.name + '</span></a><br>' +
                            '<span>' + item.email + '</span></div>' +
                            '</div>' +
                            '</div>' +
                            '</td>' +
                            '<td>' +
                            '<button class="btn btn-success btn-sm px-2 me-1 viewbtn" value="'+item.id+'"><i class="icon-eye fs-16" cursorshover="true"></i></button>' +
                            '<button  class="btn btn-primary btn-sm px-2 me-1 editbtn" value="'+item.id+'"><i class="icon-pencil fs-16" cursorshover="true"></i></button>' +
                            '<button class="btn btn-danger btn-sm px-2 deletebtn" type="button" value="'+item.id+'" data-bs-original-title="" title="" data-original-title="btn btn-primary-gradien"><i class="icon-trash fs-16" cursorshover="true"></i></button>' +
                            '</td></tr>'
                        );
                    });
                    //console.log(data.total);
                    $("#to-records").text(data.to);
                    $("#total-records").text(data.total);
                    if (data.prev_page_url === null) {
                        $("#prev-btn").attr('disabled', true);
                    } else {
                        $("#prev-btn").attr('disabled', false);
                    }
                    if (data.next_page_url === null) {
                        $("#next-btn").attr('disabled', true);
                    } else {
                        $("#next-btn").attr('disabled', false);
                    }
                    $("#prev-btn").val(data.prev_page_url);
                    $("#next-btn").val(data.next_page_url);
                } else {
                    $(".show-alert").show();
                    $(".pagination").hide();
                    $(".data-loading").hide();
                }
            }
        });
    }
    $('.pagination-btn').click(function() {
        //clicked url json data
        $(".data-loading").show();
        $("#fetched-data").empty();
        var clicked_url = $(this).val();

        $(this).siblings().removeClass('active')
        $(this).addClass('active');
        $.ajax({
            url: clicked_url,
            type: 'GET',
            data: {},
            success: function(data) {
                $.each(data.data, function(key, item) {
                    //console.log(response.users.data);
                    $("#fetched-data").append('<tr>' +
                        '<td class="img-content-box">' +
                        '<div class="media">' +
                        '<div class="square-box me-2"><img class="img-fluid b-r-5" src="https://admin.pixelstrap.com/zeta/assets/images/avtar/chinese.png" alt=""></div>' +
                        '<div class="media-body ps-2">' +
                        '<div class="avatar-details"><a href="product-page.html">' +
                        '<span>' + item.name + '</span></a><br>' +
                        '<span>' + item.email + '</span></div>' +
                        '</div>' +
                        '</div>' +
                        '</td>' +
                        '<td>' +
                        '<button class="btn btn-success btn-sm px-2 me-1 viewbtn" value="'+item.id+'"><i class="icon-eye fs-16" cursorshover="true"></i></button>' +
                        '<button class="btn btn-primary btn-sm px-2 me-1 editbtn" value="'+item.id+'"><i class="icon-pencil fs-16" cursorshover="true"></i></button>' +
                        '<button class="btn btn-danger btn-sm px-2 deletebtn" type="button" value="'+item.id+'" data-bs-original-title="" title="" data-original-title="btn btn-primary-gradien"><i class="icon-trash fs-16" cursorshover="true"></i></button>' +
                        '</td></tr>'
                    );
                });
                $(".data-loading").hide();


                $("#to-records").text(data.to);
                if (data.prev_page_url === null) {
                    $("#prev-btn").attr('disabled', true);
                } else {
                    $("#prev-btn").attr('disabled', false);
                }
                if (data.next_page_url === null) {
                    $("#next-btn").attr('disabled', true);
                } else {
                    $("#next-btn").attr('disabled', false);
                }
                $("#prev-btn").val(data.prev_page_url);
                $("#next-btn").val(data.next_page_url);
            }
        });
    });
    $('#save').on('click', function() {
        var name = $('input[name="name"]').val();
        var email = $('input[name="email"]').val();
        var password = $('input[name="password"]').val();
        role        = $("input[type='radio']:checked").val();
        var confirmPassword = $('input[name="confirmPassword"]').val();

        $.ajax({
            url: "cx-team/store",
            type: "POST",
            data: {
                name: name,
                email: email,
                password: password,
                role:role,
                confirmPassword: confirmPassword,
                _token: $("input[name=_token]").val()
            },
            dataType: 'json',
            success: function(data) {
                if (data.status == 400) {
                    $('#save_msgList').html("");
                    $('#save_msgList').addClass('alert alert-danger');
                    $.each(data.errors, function(key, err_value) {
                        $('#save_msgList').append('<li>' + err_value + '</li>');
                    });
                    $('.add_student').text('Save');
                } else {
                    $('#save_msgList').html("");
                    $('#success_message').addClass('alert alert-success');
                    $('#success_message').text(data.message);
                    $('#AddStudentModal').find('input').val('');
                    $('.add_student').text('Save');
                    $('#AddStudentModal').modal('hide');
                    Swal.fire({
                        title: "Good job!",
                        text: data.message,
                        icon: "success"
                      });
                    fetchstudent();
                }
            },
            error: function(data) {
                console.log('Error:', data);
            }
        });
    });
//delete method//

    $(".delete_student").on('click',function(e){
        e.preventDefault();
    
        $(this).text('Deleting..');
        var id = $('#deleteing_id').val();
    
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    
        $.ajax({
            type: "DELETE",
            url: "/delete-cx/" + id,
            dataType: "json",
            success: function (response) {
                // console.log(response);
                if (response.status == 404) {
                    $('#success_message').addClass('alert alert-success');
                    $('#success_message').text(response.message);
                    $('.delete_student').text('Yes Delete');
                } else {
                    $('#success_message').html("");
                    $('#success_message').addClass('alert alert-success');
                    $('#success_message').text(response.message);
                    $('.delete_student').text('Yes Delete');
                    $('#DeleteModal').modal('hide');
                    $("#deleteing_id"+id).css({
                        display: "none"
                    });
                    fetchstudent();
                }
            }
        });
    });


})

 $(document).on('click', '.editbtn', function (e) {
        e.preventDefault();
        var stud_id = $(this).val();
         //alert(stud_id);
        $('#editModal').modal('show');
        $.ajax({
            type: "GET",
            url: "/cx-team/edit/" + stud_id,
            success: function (response) {
                if (response.status == 404) {
                    $('#success_message').addClass('alert alert-success');
                    $('#success_message').text(response.message);
                    $('#editModal').modal('hide');
                } else {
                    // console.log(response.student.name);
                    $('#name').val(response.student.name);
                    $('#email').val(response.student.email);
                    $('#password').val(response.student.password);
                    $('#stud_id').val(stud_id);
                }
            }
        });
        $('.btn-close').find('input').val('');
    
    });


 $(document).on('click', '.update_student', function (e) {
        e.preventDefault();
    
        $(this).text('Updating..');
        var id = $('#stud_id').val();
        // alert(id);
         var role        = $('input[name=role]:checked', '#myForm').val()
        var name = $('#name').val();
        var email = $('#email').val();
        var password = $('#password').val();
        // var data = {
        //     'name': $('#name').val(),
        //     'email': $('#email').val(),
        //     'password': $('#password').val(),
        //     //'role':$("input[type='radio']:checked").val(),
        // }
    
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    
        $.ajax({
            type: "PUT",
            url: "/update-cx/" + id,
            data: {
                role:role,
                name: name,
                email: email,
                password: password

            },
            dataType: "json",
            success: function (response) {
                // console.log(response);
                if (response.status == 400) {
                    $('#update_msgList').html("");
                    $('#update_msgList').addClass('alert alert-danger');
                    $.each(response.errors, function (key, err_value) {
                        $('#update_msgList').append('<li>' + err_value +
                            '</li>');
                    });
                    $('.update_student').text('Update');
                } else {
                    $('#update_msgList').html("");
    
                    $('#success_message').addClass('alert alert-success');
                    $('#success_message').text(response.message);
                    $('#editModal').find('input').val('');
                    $('.update_student').text('Update');
                    $('#editModal').modal('hide');
                }
            }
        });
    
    });


$(document).on('click', '.deletebtn', function () {
    var stud_id = $(this).val();
    $('#DeleteModal').modal('show');
    $('#deleteing_id').val(stud_id);
});
$(document).on('click', '.viewbtn', function () {
    $("#viewModal").modal('show');
})

//maodal tracking //
$("#submit-btn").on('click',function(){
    var case_name = $('input[name="case_name"]').val();
    var main_category = $('input[name="main_category"]').val();
    $.ajax({
        url: "case-store",
        type: "POST",
        data: {
            case_name: case_name,
            main_category: main_category,
            _token: $("input[name=_token]").val()
        },
        dataType: 'json',
        success: function(data) {
            alert('success')
        },
        error: function(data) {
            console.log('Error:', data);
        }
    });
});
$("#submit-rex").on('click',function(){
    var rex_no = $('input[name="rex_no"]').val();
    var employee_name = $('input[name="employee_name"]').val();
    $.ajax({
        url: "rex-store",
        type: "POST",
        data: {
            rex_no: rex_no,
            employee_name: employee_name,
            _token: $("input[name=_token]").val()
        },
        dataType: 'json',
        success: function(data) {
            alert('success')
        },
        error: function(data) {
            console.log('Error:', data);
        }
    });
});


