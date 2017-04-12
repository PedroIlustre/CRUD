<?php

mysqli_report(MYSQLI_REPORT_STRICT);
function open_database() {
	try {
		$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		return $conn;
	} catch (Exception $e) {
		echo $e->getMessage();
		return null;
	}
}
function close_database($conn) {
	try {
		mysqli_close($conn);
	} catch (Exception $e) {
		echo $e->getMessage();
	}
}


# Pesquisa um Registro pelo ID 
function find( $table = null, $id = null ) {
  
	$database = open_database();
	$found = null;
	try {
            if ($id) {
                $sql = "SELECT * FROM " . $table . " WHERE id = " . $id;
                $result = $database->query($sql);
	    
                if ($result->num_rows > 0) {
                    $found = $result->fetch_assoc();
                }
	    
            } else { 
                $sql = "SELECT * FROM " . $table;
                $result = $database->query($sql);
	    
                if ($result->num_rows > 0) {
                    $found = $result->fetch_all(MYSQLI_ASSOC);

                }
            }
	} catch (Exception $e) {
	  $_SESSION['message'] = $e->GetMessage();
	  $_SESSION['type'] = 'danger';
  }
	
	close_database($database);
	return $found;
}

# Busca todos
function find_all( $table ) {
  return find($table);
}

# Insere novos funcionários
function save_new($table = null, $data = null) {
    $database = open_database();
    $columns = null;
    $values = null;
    
    foreach ($data as $key => $value) {
        $columns .= trim($key, "'") . ",";
        
        # Utiliza para criptografar senha
        if($key == "'senha'"){
            $value = base64_encode($value);   
        }
        $values .= "'$value',";
    }

    $columns = rtrim($columns, ',');
    $values = rtrim($values, ',');
    $sql = "INSERT INTO " . $table . "($columns)" . " VALUES " . "($values);";
    
    try {
        $database->query($sql);
        $_SESSION['message'] = 'Registro cadastrado com sucesso.';
        $_SESSION['type'] = 'success';

    } catch (Exception $e) { 

        $_SESSION['message'] = 'Nao foi possivel realizar a operacao.';
        $_SESSION['type'] = 'danger';
    } 
    close_database($database);
}

# Edita registros de funcionários cadastrados
function save_edit($table = null, $id = 0, $data = null) {
    $database = open_database();
    $items = null;
    
    foreach ($data as $key => $value) {
        if($key == "'senha'"){
            $items .= trim($key, "'") . "='".base64_encode($value)."',";
        }else{
            $items .= trim($key, "'") . "='$value',";
        }
    }

    $items = rtrim($items, ',');
    $sql  = "UPDATE " . $table;
    $sql .= " SET $items";
    $sql .= " WHERE id=" . $id . ";";
    try {
        $database->query($sql);
        $_SESSION['message'] = 'Registro atualizado com sucesso.';
        $_SESSION['type'] = 'success';
    } catch (Exception $e) { 
        $_SESSION['message'] = 'Nao foi possivel realizar a operacao.';
        $_SESSION['type'] = 'danger';
    } 
    close_database($database);
}

# Delete Funcionários
function remove( $table = null, $id = null ) {
  $database = open_database();
	
  try {
    if ($id) {
      $sql = "DELETE FROM " . $table . " WHERE id = " . $id;
      $result = $database->query($sql);
      if ($result = $database->query($sql)) {   	
        $_SESSION['message'] = "Registro Removido com Sucesso.";
        $_SESSION['type'] = 'success';
      }
    }
  } catch (Exception $e) { 
    $_SESSION['message'] = $e->GetMessage();
    $_SESSION['type'] = 'danger';
  }
  close_database($database);
}