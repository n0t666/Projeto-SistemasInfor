package my.ipleiria.playxchange.models;

public class Comentario {
    private int id,jogoId,utilizadorId;
    private String comentario;

    public Comentario(int id, int jogoId, int utilizadorId, String comentario) {
        this.id = id;
        this.jogoId = jogoId;
        this.utilizadorId = utilizadorId;
        this.comentario = comentario;
    }

    public int getUtilizadorId() {
        return utilizadorId;
    }

    public void setUtilizadorId(int utilizadorId) {
        this.utilizadorId = utilizadorId;
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

    public String getComentario() {
        return comentario;
    }

    public void setComentario(String comentario) {
        this.comentario = comentario;
    }
}
