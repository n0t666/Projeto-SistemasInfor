package my.ipleiria.playxchange.models;

import java.util.List;

public class Jogo {
    private int id,produtoId,quantidade,numDesejados,numJogados,numReviews;
    private String nome,dataLancamento,descricao,trailerLink,franquia,imagemCapa,distribuidora,editora,plataforma;
    private double preco,mediaAvaliacoes;


    public Jogo(String imagemCapa, int id, int quantidade, int numDesejados, int numJogados, int numReviews, String nome, String dataLancamento, String descricao, String trailerLink, String franquia, String distribuidora, String editora, String plataforma, double preco, double mediaAvaliacoes,int produtoId) {
        this.imagemCapa = imagemCapa;
        this.id = id;
        this.quantidade = quantidade;
        this.numDesejados = numDesejados;
        this.numJogados = numJogados;
        this.numReviews = numReviews;
        this.nome = nome;
        this.dataLancamento = dataLancamento;
        this.descricao = descricao;
        this.trailerLink = trailerLink;
        this.franquia = franquia;
        this.distribuidora = distribuidora;
        this.editora = editora;
        this.plataforma = plataforma;
        this.preco = preco;
        this.mediaAvaliacoes = mediaAvaliacoes;
        this.produtoId = produtoId;
    }

    public int getNumDesejados() {
        return numDesejados;
    }

    public void setNumDesejados(int numDesejados) {
        this.numDesejados = numDesejados;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getQuantidade() {
        return quantidade;
    }

    public void setQuantidade(int quantidade) {
        this.quantidade = quantidade;
    }

    public int getNumJogados() {
        return numJogados;
    }

    public void setNumJogados(int numJogados) {
        this.numJogados = numJogados;
    }

    public int getNumReviews() {
        return numReviews;
    }

    public void setNumReviews(int numReviews) {
        this.numReviews = numReviews;
    }

    public String getNome() {
        return nome;
    }

    public void setNome(String nome) {
        this.nome = nome;
    }

    public String getDataLancamento() {
        return dataLancamento;
    }

    public void setDataLancamento(String dataLancamento) {
        this.dataLancamento = dataLancamento;
    }

    public String getDescricao() {
        return descricao;
    }

    public void setDescricao(String descricao) {
        this.descricao = descricao;
    }

    public String getTrailerLink() {
        return trailerLink;
    }

    public void setTrailerLink(String trailerLink) {
        this.trailerLink = trailerLink;
    }

    public String getFranquia() {
        return franquia;
    }

    public void setFranquia(String franquia) {
        this.franquia = franquia;
    }

    public String getImagemCapa() {
        return imagemCapa;
    }

    public void setImagemCapa(String imagemCapa) {
        this.imagemCapa = imagemCapa;
    }

    public String getDistribuidora() {
        return distribuidora;
    }

    public void setDistribuidora(String distribuidora) {
        this.distribuidora = distribuidora;
    }

    public String getEditora() {
        return editora;
    }

    public void setEditora(String editora) {
        this.editora = editora;
    }

    public String getPlataforma() {
        return plataforma;
    }

    public void setPlataforma(String plataforma) {
        this.plataforma = plataforma;
    }

    public double getPreco() {
        return preco;
    }

    public void setPreco(double preco) {
        this.preco = preco;
    }

    public double getMediaAvaliacoes() {
        return mediaAvaliacoes;
    }

    public void setMediaAvaliacoes(double mediaAvaliacoes) {
        this.mediaAvaliacoes = mediaAvaliacoes;
    }

    public int getProdutoId(){
         return produtoId;
    }

    public void setProdutoId(int produtoId){
        this.produtoId = produtoId;
    }

}
