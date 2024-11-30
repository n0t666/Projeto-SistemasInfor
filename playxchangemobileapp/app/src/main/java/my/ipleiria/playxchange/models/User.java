package my.ipleiria.playxchange.models;

public class User {
    private int id;
    private String nome,nif,dataNascimento,biografia,imagemCapa,imagemPerfil;

    public User(int id, String nome, String nif, String dataNascimento, String biografia, String imagemCapa, String imagemPerfil) {
        this.id = id;
        this.nome = nome;
        this.nif = nif;
        this.dataNascimento = dataNascimento;
        this.biografia = biografia;
        this.imagemCapa = imagemCapa;
        this.imagemPerfil = imagemPerfil;
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

    public String getImagemCapa() {
        return imagemCapa;
    }

    public void setImagemCapa(String imagemCapa) {
        this.imagemCapa = imagemCapa;
    }

    public String getImagemPerfil() {
        return imagemPerfil;
    }

    public void setImagemPerfil(String imagemPerfil) {
        this.imagemPerfil = imagemPerfil;
    }
}
