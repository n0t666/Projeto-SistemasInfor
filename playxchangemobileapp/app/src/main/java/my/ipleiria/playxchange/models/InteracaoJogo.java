package my.ipleiria.playxchange.models;

import java.util.ArrayList;

public class InteracaoJogo {

    private ArrayList<Jogo> desejados, jogados, favoritos;

    public InteracaoJogo(ArrayList<Jogo> favoritos, ArrayList<Jogo> jogados, ArrayList<Jogo> desejados) {
        this.favoritos = favoritos;
        this.jogados = jogados;
        this.desejados = desejados;
    }

    public ArrayList<Jogo> getFavoritos() {
        return favoritos;
    }

    public void setFavoritos(ArrayList<Jogo> favoritos) {
        this.favoritos = favoritos;
    }

    public ArrayList<Jogo> getJogados() {
        return jogados;
    }

    public void setJogados(ArrayList<Jogo> jogados) {
        this.jogados = jogados;
    }

    public ArrayList<Jogo> getDesejados() {
        return desejados;
    }

    public void setDesejados(ArrayList<Jogo> desejados) {
        this.desejados = desejados;
    }
}
