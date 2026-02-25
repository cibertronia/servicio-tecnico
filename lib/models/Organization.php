<?php

namespace Models;

class Organization extends Model {

	public function addUser(User $user) {
		return $user->update('organization_id', $user->id);
	}

    public function get() {
        $data = $this->toArray(['id', 'created_at']);
        $data = Model::formatDates(['created_at'], $data, \DateTime::ISO8601);

        return $data;
    }
}