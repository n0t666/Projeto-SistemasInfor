package my.ipleiria.playxchange.models;

import java.util.List;

public class Jogo {
    private int id;
    private String nome;
    private String descricao;
    private String dataLancamento;
    private String capas;
    private String distribuidora;
    private String editora;
    private String trailer;
    private String franquia;
    private int desejados;
    private int jogados;
    private double media;
    private int reviews;
    private Avaliacao avaliacao;
    private Atividade atividade;
    private List<Produto> produtos;
    private List<Tag> tags;
    private List<Genero> generos;
    private List<String> screenshots;


    public Jogo(int id, String nome, String descricao, String dataLancamento, String capas, String distribuidora, String editora, String trailer, String franquia, int desejados, int jogados, double media, int reviews, Avaliacao avaliacao, Atividade atividade, List<Produto> produtos, List<Tag> tags, List<Genero> generos, List<String> screenshots) {
        this.id = id;
        this.nome = nome;
        this.descricao = descricao;
        this.dataLancamento = dataLancamento;
        this.capas = capas;
        this.distribuidora = distribuidora;
        this.editora = editora;
        this.trailer = trailer;
        this.franquia = franquia;
        this.desejados = desejados;
        this.jogados = jogados;
        this.media = media;
        this.reviews = reviews;
        this.avaliacao = avaliacao;
        this.atividade = atividade;
        this.produtos = produtos;
        this.tags = tags;
        this.generos = generos;
        this.screenshots = screenshots;
    }

    public Atividade getAtividade() {
        return atividade;
    }

    public void setAtividade(Atividade atividade) {
        this.atividade = atividade;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getNome() {
        return nome;
    }

    public void setNome(String nome) {
        this.nome = nome;
    }

    public String getDescricao() {
        return descricao;
    }

    public void setDescricao(String descricao) {
        this.descricao = descricao;
    }

    public String getDataLancamento() {
        return dataLancamento;
    }

    public void setDataLancamento(String dataLancamento) {
        this.dataLancamento = dataLancamento;
    }

    public String getCapas() {
        return capas;
    }

    public void setCapas(String capas) {
        this.capas = capas;
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

    public String getTrailer() {
        return trailer;
    }

    public void setTrailer(String trailer) {
        this.trailer = trailer;
    }

    public String getFranquia() {
        return franquia;
    }

    public void setFranquia(String franquia) {
        this.franquia = franquia;
    }

    public int getDesejados() {
        return desejados;
    }

    public void setDesejados(int desejados) {
        this.desejados = desejados;
    }

    public int getJogados() {
        return jogados;
    }

    public void setJogados(int jogados) {
        this.jogados = jogados;
    }

    public double getMedia() {
        return media;
    }

    public void setMedia(double media) {
        this.media = media;
    }

    public int getReviews() {
        return reviews;
    }

    public void setReviews(int reviews) {
        this.reviews = reviews;
    }

    public Avaliacao getAvaliacao() {
        return avaliacao;
    }

    public void setAvaliacao(Avaliacao avaliacao) {
        this.avaliacao = avaliacao;
    }

    public List<Produto> getProdutos() {
        return produtos;
    }

    public void setProdutos(List<Produto> produtos) {
        this.produtos = produtos;
    }

    public List<Tag> getTags() {
        return tags;
    }

    public void setTags(List<Tag> tags) {
        this.tags = tags;
    }

    public List<Genero> getGeneros() {
        return generos;
    }

    public void setGeneros(List<Genero> generos) {
        this.generos = generos;
    }

    public List<String> getScreenshots() {
        return screenshots;
    }

    public void setScreenshots(List<String> screenshots) {
        this.screenshots = screenshots;
    }

    public static class Atividade {
        private int id;
        private int utilizadorId;
        private int jogoId;
        private int isJogado;
        private int isDesejado;
        private int isFavorito;

        public Atividade(int id, int utilizadorId, int jogoId, int isJogado, int isDesejado, int isFavorito) {
            this.id = id;
            this.utilizadorId = utilizadorId;
            this.jogoId = jogoId;
            this.isJogado = isJogado;
            this.isDesejado = isDesejado;
            this.isFavorito = isFavorito;
        }

        public int getId() {
            return id;
        }

        public void setId(int id) {
            this.id = id;
        }

        public int getUtilizadorId() {
            return utilizadorId;
        }

        public void setUtilizadorId(int utilizadorId) {
            this.utilizadorId = utilizadorId;
        }

        public int getJogoId() {
            return jogoId;
        }

        public void setJogoId(int jogoId) {
            this.jogoId = jogoId;
        }

        public int isJogado() {
            return isJogado;
        }

        public void setJogado(int jogado) {
            isJogado = jogado;
        }

        public int isDesejado() {
            return isDesejado;
        }

        public void setDesejado(int desejado) {
            isDesejado = desejado;
        }

        public int isFavorito() {
            return isFavorito;
        }

        public void setFavorito(int favorito) {
            isFavorito = favorito;
        }
    }

    public static class Produto {
        private int id;
        private String plataformaNome;
        private int plataformaId;
        private double preco;
        private int quantidade;

        public Produto(int id, String plataformaNome, int plataformaId, double preco, int quantidade) {
            this.id = id;
            this.plataformaNome = plataformaNome;
            this.plataformaId = plataformaId;
            this.preco = preco;
            this.quantidade = quantidade;
        }

        // Getters and Setters
        public int getId() {
            return id;
        }

        public void setId(int id) {
            this.id = id;
        }

        public String getPlataformaNome() {
            return plataformaNome;
        }

        public void setPlataformaNome(String plataformaNome) {
            this.plataformaNome = plataformaNome;
        }

        public int getPlataformaId() {
            return plataformaId;
        }

        public void setPlataformaId(int plataformaId) {
            this.plataformaId = plataformaId;
        }

        public double getPreco() {
            return preco;
        }

        public void setPreco(double preco) {
            this.preco = preco;
        }

        public int getQuantidade() {
            return quantidade;
        }

        public void setQuantidade(int quantidade) {
            this.quantidade = quantidade;
        }
    }

    public static class Tag {
        private int id;
        private String nome;

        public Tag(int id, String nome) {
            this.id = id;
            this.nome = nome;
        }

        // Getters and Setters
        public int getId() {
            return id;
        }

        public void setId(int id) {
            this.id = id;
        }

        public String getNome() {
            return nome;
        }

        public void setNome(String nome) {
            this.nome = nome;
        }
    }

    public static class Genero {
        private int id;
        private String nome;

        public Genero(int id, String nome) {
            this.id = id;
            this.nome = nome;
        }

        public int getId() {
            return id;
        }

        public void setId(int id) {
            this.id = id;
        }

        public String getNome() {
            return nome;
        }

        public void setNome(String nome) {
            this.nome = nome;
        }
    }

}
