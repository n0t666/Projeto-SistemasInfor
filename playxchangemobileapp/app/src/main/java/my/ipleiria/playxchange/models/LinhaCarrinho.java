package my.ipleiria.playxchange.models;

public class LinhaCarrinho {
    private int id,idProduto,nome,quantidade;
    private String imagem;
    private double preco;

    public LinhaCarrinho(int id, int idProduto, int nome, int quantidade, double preco,String imagem) {
        this.id = id;
        this.idProduto = idProduto;
        this.nome = nome;
        this.quantidade = quantidade;
        this.preco = preco;
        this.imagem = imagem;
    }

    public int getQuantidade() {
        return quantidade;
    }

    public void setQuantidade(int quantidade) {
        this.quantidade = quantidade;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getIdProduto() {
        return idProduto;
    }

    public void setIdProduto(int idProduto) {
        this.idProduto = idProduto;
    }

    public int getNome() {
        return nome;
    }

    public void setNome(int nome) {
        this.nome = nome;
    }

    public double getPreco() {
        return preco;
    }

    public void setPreco(double preco) {
        this.preco = preco;
    }

    public String getImagem(){
        return  imagem;
    }
    public void setImagem(){
        this.imagem = imagem;
    }
}
