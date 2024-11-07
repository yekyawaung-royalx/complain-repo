$('[name=nav]').each(function(i,d){
    var p = $(this).prop('checked');
     //console.log(i);
    if(p){
      $('.content-one').eq(i)
        .addClass('on');
    }    
  });  
  
  $('[name=nav]').on('change', function(){
    var p = $(this).prop('checked');
    //console.log(p);
    
    // $(type).index(this) == nth-of-type
    var i = $('[name=nav]').index(this);
    
    $('.content-one').removeClass('on');
    $('.content-one').eq(i).addClass('on');
  });

  $(document).ready(function(){
    $(".js-select2").select2({
      closeOnSelect: true
  });
    caseType()
  })
  $("#main_category").on("change",function(){
    caseType()
  })

  function caseType(){
    var selected = $("#main_category").val();
    $("#case_type").empty();
    //console.log(selected);
    $.ajax({
      type: "GET",
      url:'casetype',
      data: {selected:selected},
      success: function(data){
      $.each(data, function(i, v) {
        //console.log(v.case_name);
        $("#case_type").append('<option class="case" value="'+v.case_name+'">'+v.case_name+'</option>')
        
    });
      }
    })
  }
  $("#e_main_category").on("change",function(){
    ecasetype()
  })
  
  function ecasetype(){
    var selected = $("#e_main_category").val();
    $("#e_case_type").empty();
   // console.log(selected);
    $.ajax({
      type: "GET",
      url:'casetype',
      data: {selected:selected},
      success: function(data){
      $.each(data, function(i, v) {
        //console.log(v.case_name);
        $("#e_case_type").append('<option class="case" value="'+v.case_name+'">'+v.case_name+'</option>')
        
    });
      }
    })
  }
  //login form

  $("#login").on("click",function(){
    const search_form = $('#login-form');
    search_form.submit();
  })
//rex number conditional state
  $("#rex-no").on("keydown",function search(e){
    var keyword=$("#rex-no").val();
    //console.log(keyword);
    if (e.keyCode == 13) {
    if(keyword.length==13){
      $("#rex-no").removeClass("border-danger");
      $.ajax({
        type: "GET",
        url: "search",
        data: {keyword:keyword},
        success: function(data){
          //console.log(data);
           if(data==''){
            $("#rex-no").addClass("border-danger");
            $(".alert-error").empty().append('<strong>မှားယွင်းနေပါသည်</strong>')
            $(".re-hide").hide();
           }else{
            $("#exampleModal").modal("hide");
            showForm();
           
           $.each(data,function(i,v){
            $("#employee_rex").val(v.employee_id)
           })
           }
        },
        error: function (data) {
            console.log('An error occurred.');
            console.log(data);
        },
      })
    }else{
      $("#rex-no").addClass("border-danger");
      $(".alert-error").empty().append('<strong>မှားယွင်းနေပါသည်</strong>')
      $(".re-hide").hide();
    }
  }
  })
//end rex number conditional state
  //interanl form click
  $("#two").on("click",function(){
    $("#exampleModal").modal("show");
    ecasetype()
  })
  $("#tree").on("click",function(){
    $("#exampleModal2").modal("show");
  })
  $("#one").on('click',function(){
    $(".re-hide").hide();
  })
//end internal form click
  //rex modal close
  $(".close,#drop").on("click",function(){
    $("#exampleModal").modal("hide");
    $("#exampleModal2").modal("hide");
  })
//end rex modal close
  //show alert rex_no
  function showForm(){
    $(".re-hide").show();
  }
  //end alert rex_no

  //customer submit form

  $('.customer-submit').on('submit', function(e){
    e.preventDefault();
   //alert('hello');
      var validate=validateForm_1();
    if(validate==false){
      return false;
    }else{
      $(".spii").show();
    var form = this;
    console.log(form);
    $.ajax({
        url:$(form).attr('action'),
        method:$(form).attr('method'),
        data:new FormData(form),
        processData:false,
        dataType:'json',
        contentType:false,
        beforeSend:function(){
            $(form).find('span.error-text').text('');
        },
        success:function(data){
            if(data.code == 0){
                $.each(data.error, function(prefix,val){
                    $(form).find('span.'+prefix+'_error').text(val[0]);
                });
                $(".spii").hide();
                $("#exampleModal1").modal("show");
                 $("#uid").empty()
                 $("#msg").empty()
                $("#uid").append('<label>Complaint ID '+data.uuid+'</label>');
                $("#msg").append('<strong>'+data.msg+'</strong>');
            }else{
                $(form)[0].reset();
                $(".spii").hide();
                $("#exampleModal1").modal("show");
                 $("#uid").empty()
                 $("#msg").empty()
                $("#uid").append('<label id="i">Complaint ID '+data.uuid+'</label>');
                $("#msg").append('<strong id="g">'+data.msg+'</strong>');
               // toastr.success(data.msg);
                //console.log(data.msg)
                // alert(data.msg);
                // fetchAllProducts();
            }
        }
    });
  }
});

  //end customer form 1
  //start customer validateForm 1

  function validateForm_1(){
    var customer_name=$("#complainant_name").val();
    var customer_phone=$("#complainant_phone").val();
    var case_type=$("#e_case_type").val();
    
    if(customer_name=='' && customer_phone==''){
      $("#complainant_name").addClass('border-danger');
      $("#complainant_phone").addClass('border-danger');
      return false;
    }
    if(customer_name==''){
      $("#complainant_name").addClass('border-danger');
      return false;
    }if(customer_phone==''){
      $("#complainant_phone").addClass('border-danger');
      return false;
    }
  }

  $('#complainant_name').keyup(function(event) {
    var input=$(this);
    var message=$(this).val();
    if(message){input.removeClass("border-danger").addClass("valid");}
    else{input.removeClass("valid").addClass("border-danger");}	
});
$('#complainant_phone').keyup(function(event) {
  var input=$(this);
  var message=$(this).val();
  if(message){input.removeClass("border-danger").addClass("valid");}
  else{input.removeClass("valid").addClass("border-danger");}	
});


//employee submit form 

$('.employee-submit').on('submit', function(e){
  e.preventDefault();
 //alert('hello');
    var validate=validateForm_2();
  if(validate==false){
    return false;
  }else{
    $(".spii").show();
  var form = this;
  $.ajax({
      url:$(form).attr('action'),
      method:$(form).attr('method'),
      data:new FormData(form),
      processData:false,
      dataType:'json',
      contentType:false,
      beforeSend:function(){
          $(form).find('span.error-text').text('');
      },
      success:function(data){
          if(data.code == 0){
              $.each(data.error, function(prefix,val){
                  $(form).find('span.'+prefix+'_error').text(val[0]);
              });
          }else{
              $(form)[0].reset();
              $(".spii").hide();
              $("#exampleModal1").modal("show");
              $("#diu").append('<label id="i">Complaint ID '+data.uuid+'</label>');
              $("#mgs").append('<strong id="g">'+data.msg+'</strong>');
              $("#mgs").show();
              $("#diu").show();
              //console.log(data.msg)
              // alert(data.msg);
              // fetchAllProducts();
          }
      }
  });
}
});

//end employee submit form

 //start customer validateForm 1

 function validateForm_2(){
  var customer_name=$("#e_complainant_name").val();
  var customer_phone=$("#e_complainant_phone").val();
  var case_type=$("#e_case_type").val();
  
  if(customer_name=='' && customer_phone==''){
    $("#e_complainant_name").addClass('border-danger');
    $("#e_complainant_phone").addClass('border-danger');
    return false;
  }
  if(customer_name==''){
    $("#e_complainant_name").addClass('border-danger');
    return false;
  }if(customer_phone==''){
    $("#e_complainant_phone").addClass('border-danger');
    return false;
  }if(case_type=='selected'){
    $(".select2.select2-container .select2-selection").addClass('border-danger');
    return false;
  }
}

$('#e_complainant_name').keyup(function(event) {
  var input=$(this);
  var message=$(this).val();
  if(message){input.removeClass("border-danger").addClass("valid");}
  else{input.removeClass("valid").addClass("border-danger");}	
});
$('#e_complainant_phone').keyup(function(event) {
var input=$(this);
var message=$(this).val();
if(message){input.removeClass("border-danger").addClass("valid");}
else{input.removeClass("valid").addClass("border-danger");}	
});

//user create form//
