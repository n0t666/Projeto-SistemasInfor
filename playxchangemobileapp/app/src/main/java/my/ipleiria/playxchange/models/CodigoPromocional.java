package my.ipleiria.playxchange.models;

public class CodigoPromocional
{
    int id,isAtivo,isUsado,percentagem;
    String codigo;

    public CodigoPromocional(int id, int isAtivo, int isUsado, int percentagem, String codigo) {
        this.id = id;
        this.isAtivo = isAtivo;
        this.isUsado = isUsado;
        this.percentagem = percentagem;
        this.codigo = codigo;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getIsAtivo() {
        return isAtivo;
    }

    public void setIsAtivo(int isAtivo) {
        this.isAtivo = isAtivo;
    }

    public int getIsUsado() {
        return isUsado;
    }

    public void setIsUsado(int isUsado) {
        this.isUsado = isUsado;
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
}
