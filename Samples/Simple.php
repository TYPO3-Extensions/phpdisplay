<!-- Looping around $records --><b>It works!</b> See content of EXT:phpdisplay/Samples/Simple.php to have more examples.<br /><!-- PHP TEMPLATE SYNTAX FOR HTML --><?php if (! empty($datastructure['page']['records'])): ?>	<?php foreach($datastructure['page']['records'] as $record): ?>		<?php print $record['title'] ?>	<?php endforeach ?><?php endif ?><?php	// debug	#\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($datastructure,'debug');	#\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($filter,'debug');	/** @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer $localCObj */	$localCObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer::class);	$localCObj->start(array(), '');	// Parameters	$parameters = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('tx_displaycontroller');	// FE USER	$feUser = $GLOBALS['TSFE']->fe_user->user;	$feUserUid = $GLOBALS['TSFE']->fe_user->user['uid'];	// link	$localCObj->start($record);	$config = array();	$config['returnLast'] = 'url';	$config['parameter.']['data'] = 'TSFE:tmpl|setup|plugin.|tx_speciality.|courses_detail_pid';	$config['additionalParams'] = '&tx_displaycontroller[table]=courses&tx_displaycontroller[showUid]={field:uid}';	$config['additionalParams.']['insertData'] = 1;	$link = $localCObj->typoLink('',$config);	// Generating thumbnails	$configThumbnail = array();	$configThumbnail['file'] = $record['file'];	$configThumbnail['altText'] = $record['title'];	$configThumbnail['file.']['height'] = 70;	$configThumbnail['file.']['width'] = 50;	$configThumbnail['file.']['minW'] = 70;	$configThumbnail['file.']['minH'] = 50;	$htmlThumbnail = $localCObj->cObjGetSingle('IMAGE', $configThumbnail);	// Generating thumbnails from PDF	$configThumbnail = array();	$configThumbnail['file'] = $record['file'];	$configThumbnail['altText'] = $record['title'];	#$configThumbnail['file.']['height'] = 70;	$configThumbnail['file.']['width'] = 50;	#$configThumbnail['file.']['minW'] = 70;	#$configThumbnail['file.']['minH'] = 50;	$configThumbnail['file.']['import.']['cObject'] = 'IMG_RESOURCE';	$configThumbnail['file.']['import.']['cObject.']['ext'] = 'jpg';	$configThumbnail['file.']['import.']['cObject.']['quality'] = '100';	$configThumbnail['file.']['import.']['cObject.']['file.']['params'] = '-trim';	$configThumbnail['file.']['import.']['cObject.']['file'] = $configThumbnail['file'];	#$configThumbnail['file.']['import.']['cObject.']['file.']['width'] = '1080';	$htmlThumbnail = $localCObj->cObjGetSingle('IMAGE', $configThumbnail);	// TypoScript configuration	$configuration = $GLOBALS['TSFE']->tmpl->setup['config.'];	// Language support	/** @var \TYPO3\CMS\Lang\LanguageService $LANG */	$LANG = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Lang\LanguageService::class);	$LANG->lang = $configuration['language'];	$LANG->charSet = 'utf-8';	$LANG->includeLLFile('EXT:speciality/Resources/Private/locallang.xml');	print $LANG->getLL('cat');	print $LANG->sL('LLL:EXT:speciality/Resources/Private/locallang.xml');	// RTE	$config['parseFunc.'] = $GLOBALS['TSFE']->tmpl->setup['lib.']['parseFunc_RTE.'];	$config['value'] = $record['bodytext'];	$value = $localCObj->TEXT($config);	// PAGEBROWSE	$conf = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_pagebrowse_pi1.'];	$conf['pageParameterName'] = 'tx_displaycontroller|page';	// Adds limit to the query and calculates the number of pages.	if ($filter['limit']['max'] != '' && $filter['limit']['max'] != '0') {		//$conf['extraQueryString'] .= '&' . $this->pObj->getPrefixId() . '[max]=' . $filter['limit']['max'];		$conf['numberOfPages'] = ceil($datastructure['news']['totalCount'] / $filter['limit']['max']);		$conf['items_per_page'] = $filter['limit']['max'];		$conf['total_items'] = $datastructure['news']['totalCount'];		$conf['total_pages'] = $conf['numberOfPages']; // duplicated, because $conf['numberOfPages'] is protected	}	else {		$conf['numberOfPages'] = 1;	}	// Defines other possible pagebrowse configuration options	#$conf['enableMorePages'] = '';	#$conf['enableLessPages'] = '';	#$conf['pagesBefore'] = '';	#$conf['pagesAfter'] = '';	print $localCObj->cObjGetSingle('USER', $conf);