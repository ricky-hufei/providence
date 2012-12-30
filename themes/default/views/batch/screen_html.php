<?php
/* ----------------------------------------------------------------------
 * views/editor/objects/screen_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2012 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */
 	$t_subject 			= $this->getVar('t_subject');
	
	$t_set	 			= $this->getVar('t_set');
	$vn_set_id	 		= $this->getVar('set_id');

	$vb_can_edit	 	= $t_subject->isSaveable($this->request);
	$vb_can_delete		= $t_subject->isDeletable($this->request);
	
	if ($vb_can_edit) {
		print $vs_control_box = caFormControlBox(
			caJSButton($this->request, __CA_NAV_BUTTON_SAVE__, _t("Execute batch edit"), 'caBatchEditorForm', array('onclick' => 'caConfirmBatchExecutionPanel.showPanel(); return false;')).' '.
			//caFormSubmitButton($this->request, __CA_NAV_BUTTON_SAVE__, _t("Execute batch edit"), 'caBatchEditorForm').' '.
			caNavButton($this->request, __CA_NAV_BUTTON_CANCEL__, _t("Cancel"), 'batch', 'Editor', 'Edit/'.$this->request->getActionExtra(), array('set_id' => $vn_set_id)),
			'', 
			''
		);
	}
?>
	<div class="sectionBox">
<?php

			print caFormTag($this->request, 'Save/'.$this->request->getActionExtra(), 'caBatchEditorForm', null, 'POST', 'multipart/form-data', '_top', array('disableUnsavedChangesWarning' => true, 'noTimestamp' => true));
		
			$va_bundle_list = array();
			$va_form_elements = $t_subject->getBundleFormHTMLForScreen($this->request->getActionExtra(), array(
									'request' => $this->request, 
									'formName' => 'caBatchEditorForm',
									'batch' => true,
									'ui_instance' => $this->getVar('t_ui')
								), $va_bundle_list);
								
			print join("\n", $va_form_elements);
			
			if ($vb_can_edit) { print $vs_control_box; }
?>
			<input type='hidden' name='set_id' value='<?php print $vn_set_id; ?>'/>
		</form>
	</div>

	<div class="editorBottomPadding"><!-- empty --></div>
	
	<?php print caEditorFieldList($va_bundle_list); ?>
	
<?php 
		print $this->render("confirm_html.php");
?>