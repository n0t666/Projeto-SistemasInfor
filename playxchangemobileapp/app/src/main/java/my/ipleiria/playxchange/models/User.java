package my.ipleiria.playxchange.models;

import java.util.ArrayList;

public class User {
    private int id;
    private String nome,nif,dataNascimento,biografia,imagemCapa,imagemPerfil,username,email;
    private int seguidores,seguidos,jogosJogados,jogosFavoritos,jogosDesejados;
    private ArrayList<Jogo> favoritosPreview;

    public User(String biografia, int id, String nome, String nif, String dataNascimento, String imagemCapa, String imagemPerfil, String username, String email, int seguidores, int seguidos, int jogosJogados, int jogosFavoritos, int jogosDesejados, ArrayList<Jogo> favoritosPreview) {
        this.biografia = biografia;
        this.id = id;
        this.nome = nome;
        this.nif = nif;
        this.dataNascimento = dataNascimento;
        this.imagemCapa = imagemCapa;
        this.imagemPerfil = imagemPerfil;
        this.username = username;
        this.email = email;
        this.seguidores = seguidores;
        this.seguidos = seguidos;
        this.jogosJogados = jogosJogados;
        this.jogosFavoritos = jogosFavoritos;
        this.jogosDesejados = jogosDesejados;
        this.favoritosPreview = favoritosPreview;
    }

    public String getImagemCapa() {
        return imagemCapa;
    }

    public void setImagemCapa(String imagemCapa) {
        this.imagemCapa = imagemCapa;
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

    public String getNif() {
        return nif;
    }

    public void setNif(String nif) {
        this.nif = nif;
    }

    public String getDataNascimento() {
        return dataNascimento;
    }

    public void setDataNascimento(String dataNascimento) {
        this.dataNascimento = dataNascimento;
    }

    public String getBiografia() {
        return biografia;
    }

    public void setBiografia(String biografia) {
        this.biografia = biografia;
    }

    public String getImagemPerfil() {
        return imagemPerfil;
    }

    public void setImagemPerfil(String imagemPerfil) {
        this.imagemPerfil = imagemPerfil;
    }

    public String getUsername() {
        return username;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public int getSeguidores() {
        return seguidores;
    }

    public void setSeguidores(int seguidores) {
        this.seguidores = seguidores;
    }

    public int getSeguidos() {
        return seguidos;
    }

    public void setSeguidos(int seguidos) {
        this.seguidos = seguidos;
    }

    public int getJogosJogados() {
        return jogosJogados;
    }

    public void setJogosJogados(int jogosJogados) {
        this.jogosJogados = jogosJogados;
    }

    public int getJogosFavoritos() {
        return jogosFavoritos;
    }

    public void setJogosFavoritos(int jogosFavoritos) {
        this.jogosFavoritos = jogosFavoritos;
    }

    public int getJogosDesejados() {
        return jogosDesejados;
    }

    public void setJogosDesejados(int jogosDesejados) {
        this.jogosDesejados = jogosDesejados;
    }

    public ArrayList<Jogo> getFavoritosPreview() {
        return favoritosPreview;
    }

    public void setFavoritosPreview(ArrayList<Jogo> favoritosPreview) {
        this.favoritosPreview = favoritosPreview;
    }
}
