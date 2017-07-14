function handleGroupClick(event) {
  //marker
  $('#marker').attr('translation', event.hitPnt)

  var coordinates = event.hitPnt;
  $('#coordX').html(coordinates[0]);
  $('#coordY').html(coordinates[1]);
  $('#coordZ').html(coordinates[2]);

  console.log(coordinates[1], coordinates[2], coordinates[0]);
}