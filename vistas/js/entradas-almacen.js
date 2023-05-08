
$(".btnVerSolicitados").click(function(){
  let identificador= $(this).attr("idEntrada");
  let fecha= $(this).attr("fEntrada");
  window.location="index.php?ruta=productoss&ingreso="+identificador+"&f="+fecha;
})