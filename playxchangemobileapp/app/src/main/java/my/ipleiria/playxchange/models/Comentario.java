package my.ipleiria.playxchange.models;

public class Comentario {
    private int id;
    private double numEstrelas;
    private String comentario;
    private Jogo jogo;

    public Comentario(int id, double numEstrelas, String comentario,Jogo jogo)
    {
        this.id = id;
        this.numEstrelas = numEstrelas;
        this.comentario = comentario;
        this.jogo = jogo;

    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public double getNumEstrelas() {
        return numEstrelas;
    }

    public void setNumEstrelas(double numEstrelas) {
        this.numEstrelas = numEstrelas;
    }

    public String getComentario() {
        return comentario;
    }

    public void setComentario(String comentario) {
        this.comentario = comentario;
    }

    public Jogo getJogo() {
        return jogo;
    }

    public void setJogo(Jogo jogo) {
        this.jogo = jogo;
    }


}
