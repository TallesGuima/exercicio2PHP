<?php 
    enum Tipo: string{
        case indefinido = 'Indefinido';
        case fisico = 'Físico';
        case ebook = 'Ebook';
    }

    enum Status: string {
        case indefinido = 'Indefinido';
        case disponivel = 'Disponível';
        case emprestado = 'Emprestado';
        case reservado = 'Reservado';
    }

    
    class Livro{
        private string $titulo;
        private string $autor;
        private string $editora;
        private string $ISBN;
        private int $paginas = 0;
        private int $anoPublicacao = 0;
        private Tipo $tipo;
        private Status $status;

        public function __construct(
          string $titulo, string $autor,
          string $editora, string $ISBN,
          int $paginas, int $anoPublicacao,
          Tipo $tipo, Status $status) {
            $this->titulo = $titulo == '' ? 'Indefinido' : $titulo;
            $this->autor = $autor == '' ? 'Indefinido' : $autor;
            $this->editora = $editora == '' ? 'Indefinido' : $editora;
            $this->ISBN = $ISBN == '' ? 'Indefinido' : $ISBN;
            $this->paginas = $paginas == '' ? 0 : $paginas;
            $this->anoPublicacao = $anoPublicacao;
            $this->tipo = $tipo;
            $this->status = $status;

        }

        public function getTitulo(): string {
        	return $this->titulo;
        }

        public function getAutor(): string {
        	return $this->autor;
        }

        public function getEditora(): string {
        	return $this->editora;
        }

        public function getISBN(): string {
        	return $this->ISBN;
        }

        public function getPaginas(): int {
        	return $this->paginas;
        }

        public function getAnoPublicacao(): int {
        	return $this->anoPublicacao;
        }

        public function getTipo(): Tipo {
        	return $this->tipo;
        }

        public function getStatus(): Status {
        	return $this->status;
        }

        public function __toString(): string {
        	return "Titulo: {$this->titulo}, Autor: {$this->autor}, Editora: {$this->editora}, ISBN: {$this->ISBN}, Paginas: {$this->paginas}, AnoPublicacao: {$this->anoPublicacao}, Tipo: {$this->tipo->value}, Status: {$this->status->value}";
        }

        public function setStatus(Status $status): void {
        	$this->status = $status;
        }
    }

   $livro1 = new Livro(
        "O Pequeno Príncipe", 
        "Antoine de Saint-Exupéry", 
        "Editora Nova Fronteira", 
        "9788520921041", 
        224, 
        1943, 
        Tipo::fisico, 
        Status::disponivel 
    );

    $livro2 = new Livro(
        "O Senhor dos Anéis", 
        "J.R.R. Tolkien", 
        "Editora Martins Fontes", 
        "9788535923393", 
        1136, 
        1954, 
        Tipo::fisico, 
        Status::disponivel 
    );

    $livro3 = new Livro(
        "Fahrenheit 451", 
        "Ray Bradbury", 
        "Editora Globo Livros", 
        "9788522000128", 
        176, 
        1953, 
        Tipo::ebook, 
        Status::disponivel 
    );
      
     
