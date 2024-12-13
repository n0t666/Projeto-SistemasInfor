package my.ipleiria.playxchange.models;

public class CodigoPromocional {
    int id, status, percentagem;
    String codigo;
    double valorDescontado;

    public CodigoPromocional(int id, int status, int percentagem, String codigo, double valorDescontado) {
        this.id = id;
        this.status = status;
        this.percentagem = percentagem;
        this.codigo = codigo;
        this.valorDescontado = valorDescontado;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }


    public int getStatus() {
        return status;
    }

    public void setStatus(int status) {
        this.status = status;
    }

    public int getPercentagem() {
        return percentagem;
    }

    public void setPercentagem(int percentagem) {
        this.percentagem = percentagem;
    }

    public String getCodigo() {
        return codigo;
    }

    public void setCodigo(String codigo) {
        this.codigo = codigo;
    }

    public double getValorDescontado() {
        return valorDescontado;
    }

    public void setValorDescontado(double valorDescontado) {
        this.valorDescontado = valorDescontado;
    }
}
