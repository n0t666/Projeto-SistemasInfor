package my.ipleiria.playxchange.models;

public class Avaliacao {
    private int id,jogoId,utilizadorId;
    private String dataAvaliacao;
    private double numEstrelas;

    public Avaliacao(int id, int jogoId, int utilizadorId, double numEstrelas, String dataAvaliacao) {
        this.id = id;
        this.jogoId = jogoId;
        this.utilizadorId = utilizadorId;
        this.numEstrelas = numEstrelas;
        this.dataAvaliacao = dataAvaliacao;
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

    public double getNumEstrelas() {
        return numEstrelas;
    }

    public void setNumEstrelas(double numEstrelas) {
        this.numEstrelas = numEstrelas;
    }

    public String getDataAvaliacao() {
        return dataAvaliacao;
    }

    public void setDataAvaliacao(String dataAvaliacao) {
        this.dataAvaliacao = dataAvaliacao;
    }
}
