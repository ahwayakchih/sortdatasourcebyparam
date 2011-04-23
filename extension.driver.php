<?php
	Class extension_sortdatasourcebyparam extends Extension{
	
		public function about(){
			return array('name' => __('Sort Data Source by Parameters'),
						 'version' => '1.0',
						 'release-date' => '2011-04-22',
						 'author' => array('name' => 'Marcin Konicki',
										   'website' => 'http://ahwayakchih.neoni.net',
										   'email' => 'ahwayakchih@neoni.net'),
						 'description' => __('Modifies Data Source edit page to allow entering parameters to be used for sort and order options.')
			);
		}

		public function getSubscribedDelegates(){
			return array(
/*
				array(
					'page' => '/backend/',
					'delegate' => 'AdminPagePostGenerate',
					'callback' => 'modifyHTMLSource'
				),
*/
				array(
					'page' => '/backend/',
					'delegate' => 'InitaliseAdminPageHead',
					'callback' => 'addJavaScriptAndCSS'
				),
			);
		}
/*
		public function modifyHTMLSource($ctx) {
			// @ctx - context array contains: $output

			$callback = Symphony::Engine()->getPageCallback();
			if ($callback['driver'] != 'blueprintsdatasources' || !is_array($callback['context'])) return;

			$handle = NULL;
			if ($callback['context'][0] == 'edit' && !empty($callback['context'][1])) {
				$handle = $callback['context'][1];
			}

			$sort = '';
			$order = '';
			if (!empty($handle)) {
				$datasourceManager = new DatasourceManager(Symphony::Engine());
				$existing =& $datasourceManager->create($handle, NULL, false);
				if (!empty($existing)) {
					$sort = $existing->dsParamSORT;
					$order = ($existing->dsParamORDER == 'rand' ? 'random' : $existing->dsParamORDER);
				}
			}

			$ctx['output'] = preg_replace('%(<select[^>]+name=")fields\[sort\]"%', '<input type="text" name="fields[sort-input]" id="sort-input" value="'.$sort.'"/>$1fields[sort]" id="sort"', $ctx['output']);
			$ctx['output'] = preg_replace('%(<select[^>]+name=")fields\[order\]"%', '<input type="text" name="fields[order-input]" id="order-input" value="'.$order.'"/>$1fields[order]" id="order"', $ctx['output']);
		}
*/
		public function addJavaScriptAndCSS() {
			$callback = Symphony::Engine()->getPageCallback();
			if ($callback['driver'] != 'blueprintsdatasources' || !is_array($callback['context'])) return;

			// Find data source handle.
			$handle = NULL;
			if ($callback['context'][0] == 'edit' && !empty($callback['context'][1])) {
				$handle = $callback['context'][1];
			}

			// Find current sort and order values.
			$sort = '';
			$order = '';
			if (!empty($handle)) {
				$datasourceManager = new DatasourceManager(Symphony::Engine());
				$existing =& $datasourceManager->create($handle, NULL, false);
				if (!empty($existing)) {
					$sort = $existing->dsParamSORT;
					$order = ($existing->dsParamORDER == 'rand' ? 'random' : $existing->dsParamORDER);
				}
			}

			// Let our script know sort and order values.
			Administration::instance()->Page->addElementToHead(
				new XMLElement(
					'script',
					"Symphony.Context.add('sortdatasourcebyparam', " . json_encode(array('sort' => $sort, 'order' => $order)) . ");",
					array('type' => 'text/javascript')
				), 100
			);

			// Append scripts and styles for field settings pane
			Administration::instance()->Page->addScriptToHead(URL . '/extensions/sortdatasourcebyparam/assets/sortdatasourcebyparam.settings.js', 101, false);
		}
	}

