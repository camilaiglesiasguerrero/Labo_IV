<?php 
class Usuario
{
	public $id;
	public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $usuario;
    public $habilitado;

	public static function TraerMiPerfil($id) 
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select id,nombre,apellido,email,password,usuario,habilitado from usuarios where id=$id");
		$consulta->execute();
		$perfil= $consulta->fetchObject('Usuario');
		return $perfil;				
	}

	public function GuardarPerfil()
	{
	 	if($this->id>0)
	 	{
	 		$this->ModificarPerfil();
	 	}
	}

 	public function ModificarPerfil()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				UPDATE usuarios
				set nombre=:nombre,apellido=:apellido,email=:email,password=:password,usuario=:usuario,habilitado=:habilitado
				WHERE id=:id");
			$consulta->bindValue(':id',$this->id, PDO::PARAM_INT);
			$consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);
			$consulta->bindValue(':apellido',$this->apellido, PDO::PARAM_STR);
			$consulta->bindValue(':email',$this->email, PDO::PARAM_STR);
            $consulta->bindValue(':password',md5($this->password), PDO::PARAM_STR);
            $consulta->bindValue(':usuario',$this->usuario,PDO::PARAM_STR);
            $consulta->bindValue(':habilitado',$this->habilitado,PDO::PARAM_BOOL);
			return $consulta->execute();
	}	

	public function TraerTodosLosPerfiles()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta("select id,nombre,apellido,email,password,usuario,habilitado from usuarios");
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_CLASS,"Usuario");
	}

	public function BorrarPerfil()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->retornarConsulta("
			DELETE 
			FROM usuarios
			WHERE id=:id");
		$consulta->bindValue(':id',$this->id, PDO::PARAM_INT);		
		$consulta->execute();
		return $consulta->rowCount();
	}

}

 ?>