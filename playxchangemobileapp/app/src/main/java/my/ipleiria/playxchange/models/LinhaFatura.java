package my.ipleiria.playxchange.models;

public class LinhaFatura {
    private int id,idProduto,nome,quantidade;
    private String imagem;
    private double preco;

    public LinhaFatura(int id, int idProduto, int nome, int quantidade, String imagem, double preco) {
        this.id = id;
        this.idProduto = idProduto;
        this.nome = nome;
        this.quantidade = quantidade;
        this.imagem = imagem;
        this.preco = preco;
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

    public int getQuantidade() {
        return quantidade;
    }

    public void setQuantidade(int quantidade) {
        this.quantidade = quantidade;
    }

    public String getImagem() {
        return imagem;
    }

    public void setImagem(String imagem) {
        this.imagem = imagem;
    }

    public double getPreco() {
        return preco;
    }

    public void setPreco(double preco) {
        this.preco = preco;
    }
}
