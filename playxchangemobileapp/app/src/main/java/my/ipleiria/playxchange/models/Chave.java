package my.ipleiria.playxchange.models;

public class Chave
{
    int id,isUsada;
    String chave;

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getIsUsada() {
        return isUsada;
    }

    public void setIsUsada(int isUsada) {
        this.isUsada = isUsada;
    }

    public String getChave() {
        return chave;
    }

    public void setChave(String chave) {
        this.chave = chave;
    }

    public Chave(int id, int isUsada, String chave) {
        this.id = id;
        this.isUsada = isUsada;
        this.chave = chave;
    }
}
