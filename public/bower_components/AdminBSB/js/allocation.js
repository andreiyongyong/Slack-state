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
                  console.log("drop");
                  var dropped = ui.draggable;
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
          });
          $("#drop").sortable();

          $("#origin").droppable({ accept: ".draggable", drop: function(event, ui) {
              console.log("origin drop");
              var dropped = ui.draggable;
              var droppedOn = $(this);
              var clone = $(dropped).clone();
              $(dropped).css({top: 0,left: 0});

              $.ajax({
                  type : 'post',
                  url : instance.urls.updateUserResources,
                  data : {
                      id : dropped.attr('data-id'),
                      user_id : $('#select-user').val()
                  },
                  success : function (allow) {
                      if(allow){
                          clone.detach().css({top: 0,left: 0}).appendTo(droppedOn);
                          $(".draggable").draggable({ cursor: "crosshair", revert: "invalid"});
                      }
                  }
              });

          }});


          body.on('change', '#select-user', function () {
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
              $('#origin').append('<div id="resource_'+ el.id +'" data-pr_id="'+ el.project_id +'" data-id="'+ el.id +'" class="draggable resource-block ui-draggable ui-draggable-handle ui-sortable-handle"' +
                  'style="position: relative; left: 0; top: 0;" > <div>Project : '+ el.pr_name +'</div><div>Resource : '+ el.title +'</div></div>');
          });
          $(".draggable").draggable({ cursor: "crosshair", revert: "invalid"});
      };

      instance.renderRightResources = function (data) {
          $('#drop').html('');

          $.each(data, function (index, el) {
              $('#drop').append('<div id="resource_'+ el.id +'" data-pr_id="'+ el.project_id +'" data-id="'+ el.id +'" class="draggable ui-draggable ui-draggable-handle resource-block ui-sortable-handle"' +
                  'style="position: relative; left: 0; top: 0;" > <div>Project : '+ el.pr_name +'</div><div>Resource : '+ el.title +'</div></div>');
          });
          $(".draggable").draggable({ cursor: "crosshair", revert: "invalid"});
      };
  };
    instance.init();
};
Allocation();
