package my.ipleiria.playxchange.models;

public class Screenshot {
    private int id;
    private String filename;

    public Screenshot(int id ,String filename) {
        this.id = id;
        this.filename = filename;
    }

    public void setFilename(String filename){
        this.filename = filename;
    }

    public void setId(int id){
        this.id = id;
    }

}
