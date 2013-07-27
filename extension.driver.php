<?php
	Class extension_sortdatasourcebyparam extends Extension{
	
		public function about(){
			return array('name' => __('Sort Data Source by Parameters'),
						 'version' => '1.2',
						 'release-date' => '2013-07-27',
						 'author' => array('name' => 'Marcin Konicki',
										   'website' => 'http://ahwayakchih.neoni.net',
										   'email' => 'ahwayakchih@neoni.net'),
						 'description' => __('Modifies Data Source edit page to allow specyfying parameters that will be used for sort and order options.')
			);
		}

		public function getSubscribedDelegates(){
			return array(
				array(
					'page' => '/backend/',
					'delegate' => 'InitaliseAdminPageHead',
					'callback' => 'addJavaScriptAndCSS'
				),
			);
		}

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
				$existing = DatasourceManager::create($handle, NULL, false);
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

