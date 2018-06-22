var messageTemplates = function () {
  var instance = this;

  instance = {
      current_tmp: -1,
      urls : {
          addTemplate    : '/sq-management/public/templates/store',
          getTemplates   : '/sq-management/public/templates/get',
          deleteTemplate : '/sq-management/public/templates/destroy',
          getTempContent : '/sq-management/public/templates/get-content',
          saveContent    : '/sq-management/public/templates/save-content'
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

  instance.renderNotify = function (error, msg) {
      $('.msg-notify').html(msg).toggleClass('msg-err', error);
      setTimeout(function () {
          $('.msg-notify').html(' ');
      }, 4000);
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
              $('.current-template').hide();
              instance.toggleLoader(false);
          }
      });
  };

  instance.renderTemplateContent = function () {
      $.ajax({
          type: 'get',
          url: instance.urls.getTempContent + '/' + instance.current_tmp,
          success: function (content) {
              $('#temp-message').val(content);
          }
      });
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
                      instance.renderNotify(response.error, response.msg);
                      $('new-title').val('');
                      $('#addTempModal').modal('hide');
                  }
              });
          });

          body.on('click', '.template-block', function () {
              $('.template-block').toggleClass('active', false);
              $(this).toggleClass('active', true);
              instance.current_tmp = $(this).attr('data-id');
              instance.renderTemplateContent();
              $('.current-template').show();
          });

          body.on('click','#delete-template', function(){
              console.log(instance);
              if(instance.current_tmp != -1){
                  $.ajax({
                      type: 'get',
                      url: instance.urls.deleteTemplate + '/' + instance.current_tmp,
                      success: function (response) {
                          instance.renderTemplates();
                          instance.renderNotify(response.error, response.msg);
                          instance.current_tmp = -1;
                      }
                  });
              }else{
                  instance.renderNotify(true, 'select template to remove')
              }
          });

          body.on('click', '#save-template', function () {
              $.ajax({
                  type: 'post',
                  url: instance.urls.saveContent,
                  data: {
                      id : instance.current_tmp,
                      content : $('#temp-message').val()
                  },
                  beforeSend: function () {
                      instance.toggleLoader(true);
                  },
                  success: function (response) {
                      instance.renderNotify(response.error, response.msg);
                      instance.toggleLoader(false);
                  }
              });
          });
      });
  };

  instance.init();
};
messageTemplates();
