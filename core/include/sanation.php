<?php

class CSanitize {

	// Функция санации входных данных
	public function dataSanation($dataStr,$dataType) {
		
		switch($dataType) {
			case 'login':
				// Функция санации логина
				$res = $this->sanitizeLogin($dataStr);
				break;
			case 'password':
				// Функция санации пароля
				$res = $this->sanitizePwd($dataStr);
				break;
			case 'uri':
				// Проверяем корректность uri
				$res = $this->sanitizeUri($dataStr);
				break;
			case 'email':
				// Корректность email
				$res = $this->sanitizeEmail($dataStr);
				break;
			case 'cleartext':
				// символьная строка
				$res = $this->sanitizeText($dataStr);
				break;
			case 'clearnumber':
				// строка, содержащая только цифры и точку
				$res = $this->sanitizeNum($dataStr);
				break;
			case 'plaintext':
				// чистый текст (экранирование спецсимволов)
				$res = $this->sanitizePlain($dataStr);
				break;
			case 'fullhtml':
				// сохранение html-кода
				$res = $this->sanitizeHtml($dataStr);
				break;
			default:
				$res = false;
		}
		return $res;
	}
	
	private function sanitizeHtml($data) {
		$res = filter_var($data, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		return $res;
	}
	
	private function sanitizePlain($data) {
		//$res_ = htmlentities($data, ENT_NOQUOTES);
		$res = filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
		return $res;
	}
	
	private function sanitizeNum($data) {
		$res = preg_replace("[^0-9.]","",$data);
		return $res;
	}
	
	private function sanitizeText($data) {
		$res = preg_replace("[^a-zA-Z_]","",$data);
		return $res;
	}
	
	private function sanitizeLogin($data) {
		$res = preg_replace("[^a-zA-Z0-9_-]","",$data);
		if (strlen($res)==0) return false;
		return $res;
	}
	
	private function sanitizePwd($data) {
		$res = preg_replace("[^a-zA-Z0-9_-@!\? \+]","",$data);
		if (strlen($res)==0) return false;
		return $res;
	}
	
	private function sanitizeUri($data) {
		$url = trim($this->pregtrim($data));
		$res = preg_replace("[^a-zA-Z0-9_-=.,:/\&\?\+]","",$url);
		if (strlen($res) == 0) return false;
		return $res;
	}
	
	private function sanitizeEmail($data) {
		$mail=trim($this->pregtrim($data));
		$res = preg_replace("[^a-zA-Z0-9_-@.]","",$mail);
		if (!filter_var($res, FILTER_VALIDATE_EMAIL)) return false;
		if (strlen($res) == 0) return false;
		return $mail;
	}
	
	private function pregtrim($str) {
		return preg_replace("/[^\x20-\xFF]/","",@strval($str));
	}
}

?>