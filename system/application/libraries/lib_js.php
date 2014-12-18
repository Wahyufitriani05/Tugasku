<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Lib_js 
{
    
    function Lib_js() 
    {
    }

    function thickbox() 
    {
        echo "<link rel='stylesheet' href='".base_url()."assets/thickbox/thickbox.css' type='text/css' media='screen' />";
        echo "<script type='text/javascript' src='".base_url()."assets/thickbox/thickbox.js'></script>";
    }

    function chart() 
    {
        echo "<script type='text/javascript' src='".base_url()."assets/chart/Chart.js'></script>";
    }
    
    function chartNew()
    {
        echo "<script type='text/javascript' src='".base_url()."assets/chartNew/ChartNew.js'></script>";
    }
    
    function checkall()
    {
        // written by Daniel P 3/21/07
        // toggle all checkboxes found on the page
        echo "
        <script type='text/javascript'>
        function toggleCheckboxes(chkbx, targetID) {
            var inputlist = document.getElementsByTagName('input');
            var nilai;
            if (chkbx.checked) {
                nilai = true;
                chkbx.checked = true;
            } else {
                nilai = false;
                chkbx.checked = false;
            }
            for (i = 0; i < inputlist.length; i++) {
                if ( inputlist[i].getAttribute('type') == 'checkbox' && inputlist[i].getAttribute('id') == targetID ) {	// look only at input elements that are checkboxes
                    inputlist[i].checked = nilai;
                }
            }
        }
        </script>
        ";
    }
}

