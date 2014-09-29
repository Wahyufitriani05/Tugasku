<script type="text/javascript">
function Ubah_Dosen(){
    var x = document.getElementById('materialpicture');
    var xmlhttp;
    if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
      }
    else
      {// code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    xmlhttp.onreadystatechange=function()
      {
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            $('#materialpicture').fadeOut(500, function(){
                var result = xmlhttp.responseText;
                document.getElementById('materialpicture').innerHTML=result;
                $('#materialpicture').fadeIn(500);
                info_hover();
            });
        }
      else if(xmlhttp.readyState!=4)
        {
            document.getElementById("materialpicture").innerHTML= "<tr><td><img src='<?php echo base_url();?>media/css/images/loading.gif' width='100' height='100'/></td></tr>";
        }
      }
    xmlhttp.open("POST","<?php echo site_url().'/ajax/index/2';?>",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("sex="+document.getElementById("sex").value);
}
</script>