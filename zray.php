<?php
/*********************************
	Drupal Z-Ray Extension
	Version: 1.00
**********************************/
$drupalExt = new ZRayExtensionDrupal();
$zre = new \ZRayExtension('drupal');

$zre->setMetadata(array(
	'logo' => __DIR__ . DIRECTORY_SEPARATOR . 'logo.png',
));

$zre->setEnabledAfter('drupal_bootstrap');

$zre->traceFunction('node_load', function(){}, array($drupalExt, 'nodeLoad'));
	
class ZRayExtensionOpenScholar {
	public function nodeLoad($context, & $storage) {
		$wrapper = entity_metadata_wrapper('node', 2);
		if ($wrapper->__isset(OG_GROUP_FIELD)) {
			$this->getGroupData($wrapper, $context, $storage);
		}

		if ($wrapper->__isset(OG_AUDIENCE_FIELD)) {
			$this->getGroupData($wrapper->{OG_AUDIENCE_FIELD}->get(0), $context, $storage);
		}
	}

	
	private function getGroupData(\EntityMetadataWrapper $wrapper, $context, & $storage) {
		$storage['OpenScholar']['group'] = array(
			'Group name' => $wrapper->label(),
			'Group ID' => $wrapper->getIdentifier(),
		);
	}
}
