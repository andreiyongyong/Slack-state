var messageTemplates = function () {
  var instance = this;

  instance = {
      current_tmp: $('.template-block').length > 0 ? $('.template-block').first().toggleClass('active', true).attr('data-id') : -1,
      urls : {
          addTemplate    : '/templates/store',
          getTemplates   : '/templates/get',
          deleteTemplate : '/templates/destroy',
          getTempContent : '/templates/getContent'
      }
  };

  instance.init = function () {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      instance.eventListeners();
  };

  instance.toggleLoader = function (show) {
      $('.loading-block').toggleClass('display-none', !show);
  };

  instance.eventListeners = function () {
      $(document).ready(function () {
          var body = $('body');
          
          body.on('click', '#add-template-modal', function () {
              $('#addTempModal').modal('show');
          });

          body.on('click', '#add-template', function () {
              $.ajax({
                  type: 'post',
                  url: instance.urls.addTemplate,
                  data: {
                      title : $('#new-title').val()
                  },
                  success: function (response) {
                      instance.renderTemplates();
                      $('new-title').val('');
                      $('#addTempModal').modal('hide');
                  }
              });
          });

          body.on('click', '.template-block', function () {
              $('.template-block').toggleClass('active', false);
              $(this).toggleClass('active', true);
              instance.current_tmp = $(this).attr('data-id');
          });

          body.on('click','#delete-template', function(){
              console.log(instance);
              if(instance.current_tmp != -1){
                  $.ajax({
                      type: 'get',
                      url: instance.urls.deleteTemplate + '/' + instance.current_tmp,
                      success: function (response) {
                          instance.renderTemplates();
                          instance.current_tmp = -1;
                      }
                  });
              }else{
                  instance.renderNotify(true, 'select template to remove')
              }
          });

          body.on('click', '#send-group-message', function () {
              var formdata = new FormData();

              formdata.append("developers", JSON.stringify(instance.user_list));
              formdata.append("message", $('#group-message').val());

              if($('.upload-file').prop('files').length > 0)
              {
                  formdata.append("attach", $('.upload-file').prop('files')[0]);
              }

              $.ajax({
                  type: 'post',
                  url: instance.urls.sendMessage,
                  data: formdata,
                  processData: false,
                  contentType: false,
                  beforeSend: function () {
                      instance.toggleLoader(true);
                  },
                  success: function (response) {
                      instance.renderNotify(response.error, response.msg);
                      instance.toggleLoader(false);
                      $('#group-message').val('')
                  }
              });
          });

      });
  };

  instance.renderNotify = function (error, msg) {
      $('.msg-notify').html(msg).toggleClass('msg-err', error);
  };

  instance.renderTemplates = function () {
      $.ajax({
          type: 'get',
          url: instance.urls.getTemplates,
          beforeSend: function () {
              instance.toggleLoader(true);
          },
          success: function (templates) {
              $('.temp-container').html(' ');
              $.each(templates, function (index, template) {
                  $('.temp-container').append('<div class="col-xs-12 template-block" data-id="'+ template.id +'">'+ template.title +'</div>');
              });
              instance.toggleLoader(false);
          }
      });
  };

    instance.renderTemplateContent = function (temp_id) {
        $.ajax({
            type: 'get',
            url: instance.urls.getTempContent,
            beforeSend: function () {
                instance.toggleLoader(true);
            },
            success: function (templates) {
                $('.temp-container').html(' ');
                $.each(templates, function (index, template) {
                    $('.temp-container').append('<div class="col-xs-12 template-block" data-id="'+ template.id +'">'+ template.title +'</div>');
                });
                instance.toggleLoader(false);
            }
        });
    };

  instance.init();
};
messageTemplates();
