<?php

class SimplePDO {

	protected $db;

	function __construct($dbname, $dbuser, $dbpass) {
		try {
			$this->db = new PDO("mysql:host=localhost;dbname=$dbname;charset=utf8","$dbuser","$dbpass");
			$this->db->query("SET NAMES utf8");
			$this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}

	public function rows($table, $where = false) {
		if ($table) {
			$query = "SELECT * FROM $table";
			if (is_array($where)) {
				$query .= " WHERE ";
				$where_array = array();
				foreach ($where as $item) {
					if (is_array($item)) {
						if (array_key_exists($item[0], $where_array)) {
							$val = $item[0].rand(100,999);
							$query .= "$item[0]$item[1]:$val ";
							$where_array[$val] = $item[2];
						} else {
							$query .= "$item[0]$item[1]:$item[0] ";
							$where_array[$item[0]] = $item[2];
						}
					} else {
						$query .= "$item ";
					}
				}
				$query = trim($query);
			}
			$stmt = $this->db->prepare($query);
			if ($stmt) {
				if (is_array($where) && is_array($where_array)) {
					$stmt->execute($where_array);
				} else {
					$stmt->execute();
				}
				$rowcount = $stmt->rowcount();
				return $rowcount;
			}
		}
		return false;
	}

	public function select($table, $what = "*", $where = false, $order = false, $limit = false) {
		if ($table) {
			$query = "SELECT $what FROM $table";
			if (is_array($where)) {
				$query .= " WHERE ";
				$where_array = array();
				foreach ($where as $item) {
					if (is_array($item)) {
						if (array_key_exists($item[0], $where_array)) {
							$val = $item[0].rand(100,999);
							$query .= "$item[0]$item[1]:$val ";
							$where_array[$val] = $item[2];
						} else {
							$query .= "$item[0]$item[1]:$item[0] ";
							$where_array[$item[0]] = $item[2];
						}
					} else {
						$query .= "$item ";
					}
				}
				$query = trim($query);
			}
			if ($order) {
				$query .= " ORDER BY $order[0] $order[1]";
			}
			if ($limit) {
				$query .= " LIMIT $limit";
			}
			$stmt = $this->db->prepare($query);
			if ($stmt) {
				if (is_array($where) && is_array($where_array)) {
					$stmt->execute($where_array);
				} else {
					$stmt->execute();
				}
				$result = $stmt->fetchall(PDO::FETCH_ASSOC);
				return $result;
			}
		}
		return false;
	}

	public function insert($table, $data) {
		if ($table && is_array($data)) {
			$query = "INSERT INTO $table SET ";
			$insert_array = array();
			foreach ($data as $key => $value) {
				$query .= "$key=:$key, ";
				$insert_array[$key] = $value;
			}
			$query = rtrim($query, ", ");
			$stmt = $this->db->prepare($query);
			if ($stmt) {
				$stmt->execute($insert_array);
				return $this->db->lastInsertId();
			}
		}
		return false;
	}

	public function update($table, $data, $where) {
		if ($table && is_array($data) && is_array($where)) {
			$query = "UPDATE $table SET ";
			$update_array = array();
			foreach ($data as $key => $value) {
				$query .= "$key=:$key, ";
				$update_array[$key] = $value;
			}
			$query = rtrim($query, ", ");
			$query .= " WHERE ";
			$where_array = array();
			foreach ($where as $item) {
				if (is_array($item)) {
					if (array_key_exists($item[0], $where_array)) {
						$val = $item[0].rand(100,999);
						$query .= "$item[0]$item[1]:$val ";
						$where_array[$val] = $item[2];
					} else {
						$query .= "$item[0]$item[1]:$item[0] ";
						$where_array[$item[0]] = $item[2];
					}
				} else {
					$query .= "$item ";
				}
			}
			$query = trim($query);
			$final_array = array_merge($update_array, $where_array);
			$stmt = $this->db->prepare($query);
			if ($stmt) {
				$stmt->execute($final_array);
				return true;
			}
		}
		return false;
	}

	public function delete($table, $where) {
		if ($table && is_array($where)) {
			$query = "DELETE FROM $table WHERE ";
			$where_array = array();
			foreach ($where as $item) {
				if (is_array($item)) {
					if (array_key_exists($item[0], $where_array)) {
						$val = $item[0].rand(100,999);
						$query .= "$item[0]$item[1]:$val ";
						$where_array[$val] = $item[2];
					} else {
						$query .= "$item[0]$item[1]:$item[0] ";
						$where_array[$item[0]] = $item[2];
					}
				} else {
					$query .= "$item ";
				}
			}
			$query = trim($query);
			$stmt = $this->db->prepare($query);
			if ($stmt) {
				$stmt->execute($where_array);
				return true;
			}
		}
		return false;
	}

}


?>
