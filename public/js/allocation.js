var Allocation = function () {
  var instance = this;

  instance = {
      data : {
      },
      urls : {
          getResourcesByUser : '/get-resources-by-user',
          getResourcesByProject : '/get-resources-by-project',
          updateUserResources : '/update-user-resources',
          deleteUserResource : '/delete-user-resource'
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

  instance.eventListeners = function () {
      $(document).ready(function () {
          var body = $('body');

          $(".draggable").draggable({ cursor: "crosshair", revert: "invalid"});
          $("#drop").droppable({ accept: ".draggable",
              drop: function(event, ui) {
                  var dropped = ui.draggable;
                  $(dropped).css({top: 0,left: 0});
                  if(!$(dropped).hasClass('in_project')){
                      $(dropped).remove();
                      $.ajax({
                          type : 'post',
                          url : instance.urls.deleteUserResource,
                          data : {
                              id : dropped.attr('data-id'),
                              user_id : $('#select-user').val()
                          }
                      });
                  }
              }
          });
          $("#drop").sortable();

          $("#origin").droppable({ accept: ".draggable", drop: function(event, ui) {
              var dropped = ui.draggable;
              var droppedOn = $(this);
              var clone = $(dropped).clone();
              $(dropped).css({top: 0,left: 0});

              if($(dropped).hasClass('in_project')) {
                  $.ajax({
                      type: 'post',
                      url: instance.urls.updateUserResources,
                      data: {
                          id: dropped.attr('data-id'),
                          user_id: $('#select-user').val()
                      },
                      beforeSend: function () {
                          instance.toggleLoader(true);
                      },
                      success: function (allow) {
                          if (allow) {
                              clone.detach().css({top: 0, left: 0}).appendTo(droppedOn).removeClass('in_project');
                              $(".draggable").draggable({cursor: "crosshair", revert: "invalid"});
                          }
                          instance.toggleLoader(false);
                      }
                  });
              }

          }});


          body.on('change', '#select-user', function () {
              $('.users-circle').hide();
              $('.users-circle.user_'+$(this).val()).show();

              $.ajax({
                  type : 'get',
                  url : instance.urls.getResourcesByUser + '/' + $(this).val(),
                  success : function (data) {
                      instance.renderLeftResources(data);
                  }
              });
          });

          body.on('change', '#select-project', function () {
              $.ajax({
                  type : 'get',
                  url : instance.urls.getResourcesByProject + '/' + $(this).val(),
                  success : function (data) {
                      instance.renderRightResources(data);
                  }
              });
          });

      });

      instance.renderLeftResources = function (data) {
          $('#origin').html('');

          $.each(data, function (index, el) {
              var detail_content = '';
              if(el.details.length > 0){
                  detail_content = '<div>Details`</div>';
                  $.each(el.details, function (index, detail) {
                      detail_content += '<div>'+detail.key+' : '+ detail.value +'</div>';
                  });
              }

              $('#origin').append('<div id="resource_'+ el.id +'" data-pr_id="'+ el.project_id +'" data-id="'+ el.id +'" class="draggable resource-block ui-draggable ui-draggable-handle ui-sortable-handle"' +
                  ' style="position: relative; left: 0; top: 0;" > <div>Project : '+ el.pr_name +'</div><div>Resource : '+ el.name +'</div><div>Content : '+ el.content +'</div>'+detail_content+'</div>');

          });
          $(".draggable").draggable({ cursor: "crosshair", revert: "invalid"});
      };

      instance.renderRightResources = function (data) {
          $('#drop').html('');

          $.each(data, function (index, el) {
              var detail_content = '';
              if(el.details.length > 0){
                  detail_content = '<div>Details`</div>';
                  $.each(el.details, function (index, detail) {
                      detail_content += '<div>'+detail.key+' : '+ detail.value +'</div>';
                  });
              }

              $('#drop').append('<div id="resource_'+ el.id +'" data-pr_id="'+ el.project_id +'" data-id="'+ el.id +'" class="draggable in_project ui-draggable ui-draggable-handle resource-block ui-sortable-handle"' +
                  ' style="position: relative; left: 0; top: 0;" > <div>Project : '+ el.pr_name +'</div><div>Resource : '+ el.name +'</div><div>Content : '+ el.content +'</div>'+detail_content+'</div>');
          });
          $(".draggable").draggable({ cursor: "crosshair", revert: "invalid"});
      };

      instance.toggleLoader = function (show) {
          $('.loading-block').toggleClass('display-none', !show);
      };
  };
    instance.init();
};
Allocation();
