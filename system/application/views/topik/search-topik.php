<script>
function populateElement(selector, defvalue) {
    $(selector).each(function() {
        if($.trim(this.value) == "") {
            this.value = defvalue;
        }
    });

    $(selector).focus(function() {
        if(this.value == defvalue) {
            this.value = "";
            $('#search').attr('color', black);
        }
    });

    $(selector).blur(function() {
        if($.trim(this.value) == "") {
            this.value = defvalue;
            $('#search').attr('color', grey);
        }
    });
 }

function CariNama(){
    if($("#search").getAttribute("value").length>=3){
        $.ajax({
           type: "POST",
           url: "<?php echo site_url('kbk/cariDosen');?>",
           data: "nama="+$("#search").getAttribute("value"),
           success: function(msg){
             alert( "Nama Dosen: " + msg );
           }
         });
         alert( "Nama Dosen: " + $("#search").getAttribute("value") );
    }
    alert( "Nama Dosen: " + $("#search").getAttribute("value") );
}

$(document).ready(function(){
    populateElement("#search", "<?php if(isset($keywords))echo $keywords;else echo "Masukkan Kata Kunci di sini...";?>");
})


</script>

<form class="lable-overley-2" id="global-search-form" action="<?php echo site_url('topik/cariTopik');?>" method="post" style="padding: 0 1em 0 0;float: right;">
<!--    <label for="search" >Pencarian</label>-->
Cari Topik <input type="text" name="search" value="" id="search" onchange="CariNama()" style="height: 15px; width: 150px;"/>
    <input type="submit" name="go" class="hidden"  value="Search"  title="Go to a page with this exact name if exists"/>
</form>
