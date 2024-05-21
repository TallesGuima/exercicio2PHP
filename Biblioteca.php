<!DOCTYPE html>
<html lang="en">
<body>
    <?php 
        require "Livro.php";

        date_default_timezone_set("America/Sao_Paulo");

        class Biblioteca{
            private array $acervo = [];
            public array $datasEmprestado = [];


            public function adicionarLivro(Livro $livro){
                $this->acervo[$livro->getISBN()] = (object)$livro;
            }
    
            public function buscarLivroISBN(string $ISBN) {
                return array_key_exists($ISBN, $this->acervo) ? $this->acervo[$ISBN] : NULL;   
            }
            
            public function removerLivroISBN(string $ISBN) {
                unset($this->acervo[$ISBN]);
            }

            public function listarLivrosDisponiveis(){
                return array_filter($this->acervo, function (Livro $livro) {
                    if($livro->getStatus()->value == "Disponível"){
                        return $livro;
                    }
                });
            }
    
            public function listarLivrosEmprestado(){
                return array_filter($this->acervo, function (Livro $livro) {
                    if($livro->getStatus()->value === "Emprestado"){
                        return $livro;
                    }
                });
            }

            public function buscarLivroEmprestado($ISBN){
                if(array_key_exists($ISBN, $this->listarLivrosEmprestado())){
                    return array_filter($this->listarLivrosEmprestado(), 
                    function(Livro $livro) use ($ISBN){
                      if($livro->getISBN() === $ISBN){
                          return $livro;
                      }
                  });
                }
            }

            //Verifica se existe um array dos livros disponiveis com a chave do ISBN específico
            public function pegarLivro($ISBN){
                if(array_key_exists($ISBN, $this->listarLivrosDisponiveis())){
                    //Cria uma data atual com a chave 'dataInicial-' + ISBN e depois outra para ser a data dos dias emprestados
                    $this->datasEmprestado['dataInicial-'.$ISBN] = date_format(new DateTime(), 'd/m/Y');

                    $this->datasEmprestado[$ISBN] = new DateTime();
                    $this->datasEmprestado[$ISBN]->add(new DateInterval('P7D'));

                    //formato a data dos dias de emprestimo
                    $this->datasEmprestado[$ISBN] = date_format($this->datasEmprestado[$ISBN], 'd/m/Y');

                    $this->acervo[$ISBN]->setStatus(Status::emprestado);
                    return true;
                } 
                    return false;
            }

            public function renovarEmprestimo(string $ISBN){
                //Verifica se exite uma chave no array
                if(array_key_exists($ISBN, $this->buscarLivroEmprestado($ISBN))){
                    //Retoma o dataEmpres... como DateTime para adicionar 7 dias na data e renovar o livro por mais 7 dias
                    $this->datasEmprestado[$ISBN] = 
                    DateTime::createFromFormat('d/m/Y', $this->datasEmprestado[$ISBN])->add(new DateInterval('P7D'));

                    //Retorna para uma formatação simples
                    $this->datasEmprestado[$ISBN] = date_format($this->datasEmprestado[$ISBN], 'd/m/Y');
                }
            }
                
            
        }
        $biblioteca = new Biblioteca();

        $biblioteca->adicionarLivro($livro1);
        $biblioteca->adicionarLivro($livro2);
        $biblioteca->adicionarLivro($livro3);
        
    
        ?>
</body>
</html>