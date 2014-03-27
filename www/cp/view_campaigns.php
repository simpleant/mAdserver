<?php
global $current_section;
$current_section='campaigns';

require_once '../../init.php';

// Required files
require_once MAD_PATH . '/www/cp/auth.php';

require_once MAD_PATH . '/functions/adminredirect.php';

require_once MAD_PATH . '/www/cp/restricted.php';

require_once MAD_PATH . '/www/cp/admin_functions.php';



require_once MAD_PATH . '/www/cp/templates/header.tpl.php';

if (!check_permission('campaigns', $user_detail['user_id'])){
    exit;
}

if (isset ($_GET['action']) && $_GET['action']==1 && isset($_POST['select_campaign']) && is_array($_POST['select_campaign'])) {
    $selected_items = $_POST['select_campaign'];

    foreach ($selected_items as $item_id) {

        switch ($_POST['form_action']){

        case 'Pause':
            pause_campaign($item_id);
            break;

        case 'Run':
            run_campaign($item_id);
            break;

        case 'Delete':
            delete_campaign($item_id);
            break;
        }

    }

    global $successmessage;
    $successmessage='Your campaigns have successfully been updated.';
}

?>
<script type="text/javascript" language="javascript">
function SetAction(x) {
var answer = confirm("Are you sure you want to "+x+" the selected campaigns?")
	if (answer){
document.listform.form_action.value = x;
document.listform.submit();	}
	else{
		return false;
	}

}
</script>
<div id="content">
    <div id="contentHeader">
        <h1><?php echo __('CAMPAIGN');?></h1>
    </div> <!-- #contentHeader -->

	<div class="container">
        <form method="POST" name="listform" action="view_campaigns.php?action=1" id="listform">
            <input value="action_set" type="hidden" name="form_action">
    		 <div class="grid-24">
                 <div style="margin-bottom:10px;">
				     <button onClick="return SetAction('Pause')" class="btn btn-small btn-quaternary"><?php echo __('CAMPAIGN_PAUSE');?></button>&nbsp;&nbsp;
                     <button onClick="return SetAction('Run')" class="btn btn-small btn-quaternary"><?php echo __('CAMPAIGN_RUN');?></button>&nbsp;&nbsp;
                     <button onClick="return SetAction('Delete')" class="btn btn-small btn-quaternary"><?php echo __('CAMPAIGN_DELETE');?></button>
                 </div>

                 <div class="widget widget-table">
				     <div class="widget-header">
					     <span class="icon-list"></span>
						 <h3 class="icon chart"><?php echo __('CAMPAIGNS_LIST');?></h3>
					 </div>
					 <div class="widget-content">
                         <table id="campaignlistt" class="table table-bordered table-striped data-table">
						     <thead>
							     <tr>
                                     <th><?php echo __('CAMPAIGN_NAME');?></th>
                                     <th><?php echo __('CAMPAIGN_TYPE');?></th>
								     <th><?php echo __('CAMPAIGN_PRIORITY');?></th>
								     <th><?php echo __('CAMPAIGN_STATUS');?></th>
								     <th><?php echo __('CAMPAIGN_CREATIVE_COUNTS');?></th>
								     <th>Requests</th>
								     <th>Impressions</th>
								     <th>Clicks</th>
								     <th><?php echo __('ACTION');?></th>
							     </tr>
						     </thead>
						     <tbody>
                             <?php get_campaigns(); ?>
                             </tbody>
					    </table>
    </form>
</div>
    <!-- .widget-content -->
    </div> <!-- .widget -->

    <div class="actions">
        <button type="button" onclick="window.location='create_campaign.php';" class="btn btn-quaternary">
            <span class="icon-plus"></span><?php echo __('CAMPAIGN_CREATE');?>
        </button>
    </div> <!-- .actions -->
    </div> <!-- .grid -->

    </div> <!-- .container -->
	</div> <!-- #content -->

<?php
require_once MAD_PATH . '/www/cp/templates/footer.tpl.php';
?>