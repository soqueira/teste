$(document).ready(function() {
  $("#showPass").click(function() {
if ($(".myPass").attr("type") == "password") {
$(".myPass").attr("type", "text");
}else {
$(".myPass").attr("type", "password");
}
});
$("#showPass").click(function() {
$("#showPass i").toggle();
});
});
