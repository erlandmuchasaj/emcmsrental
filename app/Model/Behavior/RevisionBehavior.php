<?php
class RevisionBehavior extends ModelBehavior {

	public function setup(Model $Model, $settings = array()) {
		if (!empty($settings['fields'])) {
			if (is_string($settings['fields'])) {
				$this->fields = array($settings['fields']);
			} else {
				$this->fields = $settings['fields'];
			}

			$this->Revision = ClassRegistry::init('Revision');
		}
	}

	public function beforeSave(Model $Model, $options = array()) {
		if (empty($this->fields)) {
			// no fields to save
			return true;
		}

		// lets check that there is a primary key passed
		if (!$Model->id) {
			// this is a create, no need to make a revision
			return true;
		}

		$data = $Model->find('first', array(
			'conditions' => array($Model->primaryKey => $Model->id),
			'recursive' => -1,
			'callbacks' => false,
			'fields' => $this->fields,
		));

		if (!$data) {
			// no data found
			return true;
		}

		$time = time();

		foreach ($this->fields as $field) {
			if (!isset($Model->data[$Model->alias][$field])) {
				continue;
			}

			if ($data[$Model->alias][$field] == $Model->data[$Model->alias][$field]) {
				// the value has not changed, so no need to take a back up
				continue;
			}

			// lets save this revision!
			$revision = array();
			$revision['Revision']['revision'] = $time;
			$revision['Revision']['model']    = $Model->alias;
			$revision['Revision']['model_id'] = $Model->id;
			$revision['Revision']['field']    = $field;
			$revision['Revision']['value']    = $data[$Model->alias][$field];
			$revision['Revision']['user_id']  = (AuthComponent::user('id')) ? AuthComponent::user('id') : null;

			$this->Revision->create();
			$this->Revision->save($revision, false);
			$this->Revision->clear();
		}

		return true;
	}
}