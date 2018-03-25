
function submit(actionString, dataJson) {
  $.ajax({
    data: {
      action: actionString,
      dataJson: dataJson
    },
    type: 'GET',
    url: 'ajax.php',
    success: function(result) {alert('success'); console.log(result);},
    error: function() {alert('error');},

  });
}

var oldVal;

function startEditing(cell) {
  cellBeingEdited = cell;
  var elid = cell.attr('id');
  var elidSplit = elid.split('-');
  var name = elidSplit[0];
  var id   = elidSplit[1];
  var prevVal = cell.html().trim();
  oldVal = prevVal;
  var newVal = '<input class="input-active" type=text id="' + id + '" name="' + name + ' " value="' + prevVal + '">';
  cell.html(newVal);
  $('.input-active').focus();
  $('.input-active').select();
  addListenersForInput(cell);
  /*
  $('.input-active').selectionStart = 0;
  $('.input-active').selectionEnd = $('.input-active').val().length;
*/
}

function startEditingBanner(cell) {
  cellBeingEdited = cell;
  var elid = cell.attr('id');
  var elidSplit = elid.split('-');
  var name = elidSplit[0];
  var id   = elidSplit[1];
  var prevBannerPath = cell.children('img').attr('src');
  console.log(prevBannerPath);
  var prevHtml = cell.html().trim();
  oldVal = prevHtml;
  var newHtml = prevHtml + '<input class="input-active" type=file id="' + id + '" name="' + name + ' " value="' + prevBannerPath + '">'
   + '<button id="submit" type="button" value="Submit">Submit</button>'
   + '<button id="cancel" type="button" value="Cancel">Cancel</button>';
  $('.input-active').focus();
  $('.input-active').select();
  cell.html(newHtml);
  addListenersForSubmitButton(cell.children('#submit'));
  addListenersForCancelButton(cell.children('#cancel'));

}

function stopEditing(input, revert) {
  input.parent().removeClass('td-edit-active');

  var val;
  if (revert) {
    val = oldVal;
  } else {
    val = input.val().trim();
  }
  input.parent().html(val);
}

function stopEditingBanner(button) {
  console.log(button);
  console.log(button.parent());
  console.log($(button.parent()));


  button.parent().removeClass('td-edit-active');
  button.parent().children('input').remove();
  button.parent().children('button').remove();
  //button.parent().on('click', handleBannerPathClick);
  //button.parent().click(handleBannerPathClick);
  //$('.banner-path').click(handleBannerPathClick);
  //$(button.parent()).on('click', function() {console.log('clicked');});
//  $(button.parent()).click(function() {console.log('clicked');});

}

function addListenersForInput(element){

  $('input[type=text]').keyup(function(e) {
    if (e.keyCode === 13) {
      revert = false;
      $(this).blur();
      let dataJson = {
        id:  parseInt($(this).attr('id')), // banner id number for db
        key: $(this).attr('name'),
        val: $(this).val().trim(),
      };
      submit('edit', dataJson);
    }
  });


  $('input[type=text]').keyup(function(e) {
    if (e.keyCode === 27) {
      revert = true;
      $(this).blur();
      revert = false;
    }
  });

  $('input').blur(function(e) {
    stopEditing($(this), revert);
  });

}

function addListenersForSubmitButton(button) {

  button.click(function(e) {
    $filename = button.parent().children('input').val();

    stopEditingBanner(button);
    e.stopPropagation();
  });

}


function addListenersForCancelButton(button) {

  button.click(function(e) {
    console.log('cancel button clicked');
    stopEditingBanner(button);
    e.stopPropagation();
  });


}

var revert;

$('td').hover(
  function() {
    $(this).addClass('td-hover-active')
  },
  function() {
    $(this).removeClass('td-hover-active')
  }
);

var cellBeingEdited = null;
console.log('cell being edited: ' + cellBeingEdited);

$('.banner-date').click(function() {
  if (!($(this).hasClass('td-edit-active'))) {
    $(this).addClass('td-edit-active');
    startEditing($(this));
  }
});

function handleBannerPathClick() {
  console.log('banner-path clicked');
  if (!($(this).hasClass('td-edit-active'))) {
    $(this).addClass('td-edit-active');
    startEditingBanner($(this));
    //$(this).off('click');

  }

}

$('.banner-path').click(handleBannerPathClick);
