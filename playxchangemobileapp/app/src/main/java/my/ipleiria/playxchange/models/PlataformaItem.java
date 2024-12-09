package my.ipleiria.playxchange.models;

import androidx.annotation.NonNull;

public class PlataformaItem {
    private String name;
    private int produtoId;

    public PlataformaItem(String name, int id) {
        this.name = name;
        this.produtoId = id;
    }

    public String getName() {
        return name;
    }

    public int getId() {
        return produtoId;
    }

    @NonNull
    @Override
    public String toString() {
        return name;
    }
}
