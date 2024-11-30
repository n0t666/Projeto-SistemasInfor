package my.ipleiria.playxchange.models;

public class InteracaoJogo {
    private int id,jogoId,utilizadorId,isJogado,isDesejado,isFavorito;

    public InteracaoJogo(int id, int jogoId, int utilizadorId, int isJogado, int isDesejado, int isFavorito) {
        this.id = id;
        this.jogoId = jogoId;
        this.utilizadorId = utilizadorId;
        this.isJogado = isJogado;
        this.isDesejado = isDesejado;
        this.isFavorito = isFavorito;
    }

    public int getIsDesejado() {
        return isDesejado;
    }

    public void setIsDesejado(int isDesejado) {
        this.isDesejado = isDesejado;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getJogoId() {
        return jogoId;
    }

    public void setJogoId(int jogoId) {
        this.jogoId = jogoId;
    }

    public int getUtilizadorId() {
        return utilizadorId;
    }

    public void setUtilizadorId(int utilizadorId) {
        this.utilizadorId = utilizadorId;
    }

    public int getIsJogado() {
        return isJogado;
    }

    public void setIsJogado(int isJogado) {
        this.isJogado = isJogado;
    }

    public int getIsFavorito() {
        return isFavorito;
    }

    public void setIsFavorito(int isFavorito) {
        this.isFavorito = isFavorito;
    }
}
