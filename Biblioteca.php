<!DOCTYPE html>
<html lang="en">
<body>
    <?php 
        require "Livro.php";

        date_default_timezone_set("America/Sao_Paulo");

        class Biblioteca{
            private array $acervo = [];
            private array $datasEmprestado = [];

            //adiciono o livro com a key sendo o ISBN dele e forço ele a ser um object
            public function adicionarLivro(Livro $livro): void{
                $this->acervo[$livro->getISBN()] = (object)$livro;
            }
    
            //verjo se o livro com o isbn existe no acervo, se sim retorno o mesmo se nao retorno NULL
            public function buscarLivroISBN(string $ISBN): array{
                return array_key_exists($ISBN, $this->acervo) ? $this->acervo[$ISBN] : NULL;   
            }
            
            public function removerLivroISBN(string $ISBN): void {
                unset($this->acervo[$ISBN]);
            }

            //Lista os livros por meio do enum Status recebe a string com o valor exato do status procurado
            /*public function listarLivrosPorStatus(string $status): array{
                return array_filter($this->acervo, function (Livro $livro) use ($status){
                    if($livro->getStatus()->value == $status){
                        return $livro;
                    }
                });
            }*/

            //Lista os livros por meio do status: "disponivel"
            public function listarLivrosDisponiveis(): array{
                //Utilizei um array_filter com um callback retornando o livro caso o status seja igual a "Disponivel"
                return array_filter($this->acervo, function (Livro $livro) {
                    if($livro->getStatus()->value == "Disponível"){
                        return $livro;
                    }
                });
            }
            //Lista os livros por meio do status: "emprestado"
            public function listarLivrosEmprestado(): array{
                return array_filter($this->acervo, function (Livro $livro) {
                    if($livro->getStatus()->value === "Emprestado"){
                        return $livro;
                    }
                });
            }
            // Busco um livro emprestado pelo isbn
            public function buscarLivroEmprestado($ISBN): array{
                //Verifico se existe um livro com esse ISBN
                if(array_key_exists($ISBN, $this->listarLivrosEmprestado())){
                    //usei um callback pra retornar o livro com o isbn especifico
                    return array_filter($this->listarLivrosEmprestado(), 
                      function(Livro $livro) use ($ISBN){
                        if($livro->getISBN() === $ISBN){
                          return $livro;
                      }
                  });
                }
            }

            //Verifica se existe um array dos livros disponiveis com a chave do ISBN específico
            public function pegarLivro($ISBN): bool{
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

            //renova o emprestimo de livros por meio do isbn
            public function renovarEmprestimo(string $ISBN): bool{
                //Verifica se exite uma chave no array
                if(array_key_exists($ISBN, $this->buscarLivroEmprestado($ISBN))){
                    //Retoma o dataEmpres... como DateTime para adicionar 7 dias na data e renovar o livro por mais 7 dias
                    $this->datasEmprestado[$ISBN] = 
                    DateTime::createFromFormat('d/m/Y', $this->datasEmprestado[$ISBN])->add(new DateInterval('P7D'));

                    //Retorna para uma formatação simples
                    $this->datasEmprestado[$ISBN] = date_format($this->datasEmprestado[$ISBN], 'd/m/Y');
                    return true;
                }
                return false;
            }

            public function devolverLivro(string $ISBN): bool{
                if(array_key_exists($ISBN, $this->buscarLivroEmprestado($ISBN))){
                    unset($this->datasEmprestado[$ISBN]);
                    $this->acervo[$ISBN]->setStatus(Status::disponivel);
                    return true;
                }
                return false;
            }
                
            public function getDataDevolver(string $ISBN): ?bool{
                if(array_key_exists($ISBN, $this->buscarLivroEmprestado($ISBN))){
                    return $this->datasEmprestado[$ISBN];
                }
                return false;
            }

        }
        $biblioteca = new Biblioteca();

        $biblioteca->adicionarLivro($livro1);
        $biblioteca->adicionarLivro($livro2);
        $biblioteca->adicionarLivro($livro3);
        

        // echo var_dump($biblioteca->pegarLivro("9788522000128"));
        $biblioteca->pegarLivro("9788535923393");

       $biblioteca->renovarEmprestimo("9788535923393");

        // echo $biblioteca->getDataDevolver("9788535923393");


    
        ?>
</body>
</html>
