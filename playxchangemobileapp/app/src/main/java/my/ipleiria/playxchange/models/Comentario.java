package my.ipleiria.playxchange.models;

public class Comentario {
    private int id,jogoId;
    private double numEstrelas;
    private String comentario,capa,nomeJogo;

    public Comentario(String capa, int id, int jogoId, double numEstrelas, String comentario, String nomeJogo) {
        this.capa = capa;
        this.id = id;
        this.jogoId = jogoId;
        this.numEstrelas = numEstrelas;
        this.comentario = comentario;
        this.nomeJogo = nomeJogo;
    }

    public String getNomeJogo() {
        return nomeJogo;
    }

    public void setNomeJogo(String nomeJogo) {
        this.nomeJogo = nomeJogo;
    }

    public String getCapa() {
        return capa;
    }

    public void setCapa(String capa) {
        this.capa = capa;
    }

    public String getComentario() {
        return comentario;
    }

    public void setComentario(String comentario) {
        this.comentario = comentario;
    }

    public double getNumEstrelas() {
        return numEstrelas;
    }

    public void setNumEstrelas(double numEstrelas) {
        this.numEstrelas = numEstrelas;
    }

    public int getJogoId() {
        return jogoId;
    }

    public void setJogoId(int jogoId) {
        this.jogoId = jogoId;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }
}
