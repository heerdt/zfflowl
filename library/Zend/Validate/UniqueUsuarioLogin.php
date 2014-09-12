<?php
	//classe criada por luann ried turnes
	//valida se o login é único no banco... na tabela cliente... senão
	class Zend_Validate_UniqueUsuarioLogin extends Zend_Validate_Abstract
	{

		const LOGIN = 'Login';

		protected $_messageTemplates = array(
			self::LOGIN => "Login '%value%' inválido. Por favor escolha outro."
		);

		public function isValid($value)
		{
			$this->_setValue($value);

			$sql = "Select count(*) as total from usuario where login = '".$value."'";
			$rowset = Lepard_Db_Adapter::get()->fetchRow($sql);


			if (isset($rowset["total"])&&$rowset["total"]>0) {
				$this->_error(self::LOGIN);
				return false;
			}

			return true;
		}
	}