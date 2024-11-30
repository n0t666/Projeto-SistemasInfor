package my.ipleiria.playxchange.models;

import java.util.List;

public class Carrinho
{
    private int id,quantidade;

    private double total;


    public Carrinho(double total, int id, int quantidade) {
        this.total = total;
        this.id = id;
        this.quantidade = quantidade;
    }

    public double getTotal() {
        return total;
    }

    public void setTotal(double total) {
        this.total = total;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getQuantidade() {
        return quantidade;
    }

    public void setQuantidade(int quantidade) {
        this.quantidade = quantidade;
    }
}
