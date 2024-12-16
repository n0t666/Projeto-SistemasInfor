package my.ipleiria.playxchange.models;

import java.util.ArrayList;

public class Checkout {
    int codigoId;
    private double total,totalSemDesconto,valorDesconto;
    private String codigo;
    private ArrayList<MetodoPagamento> metodosPagamento;
    private ArrayList<MetodoEnvio> metodosEnvio;

    public Checkout(int codigoId, double total, double totalSemDesconto, double valorDesconto, String codigo, ArrayList<MetodoPagamento> metodosPagamento, ArrayList<MetodoEnvio> metodosEnvio) {
        this.codigoId = codigoId;
        this.total = total;
        this.totalSemDesconto = totalSemDesconto;
        this.valorDesconto = valorDesconto;
        this.codigo = codigo;
        this.metodosPagamento = metodosPagamento;
        this.metodosEnvio = metodosEnvio;
    }

    public double getTotal() {
        return total;
    }

    public void setTotal(double total) {
        this.total = total;
    }

    public int getCodigoId() {
        return codigoId;
    }

    public void setCodigoId(int codigoId) {
        this.codigoId = codigoId;
    }

    public double getTotalSemDesconto() {
        return totalSemDesconto;
    }

    public void setTotalSemDesconto(double totalSemDesconto) {
        this.totalSemDesconto = totalSemDesconto;
    }

    public double getValorDesconto() {
        return valorDesconto;
    }

    public void setValorDesconto(double valorDesconto) {
        this.valorDesconto = valorDesconto;
    }

    public String getCodigo() {
        return codigo;
    }

    public void setCodigo(String codigo) {
        this.codigo = codigo;
    }

    public ArrayList<MetodoPagamento> getMetodosPagamento() {
        return metodosPagamento;
    }

    public void setMetodosPagamento(ArrayList<MetodoPagamento> metodosPagamento) {
        this.metodosPagamento = metodosPagamento;
    }

    public ArrayList<MetodoEnvio> getMetodosEnvio() {
        return metodosEnvio;
    }

    public void setMetodosEnvio(ArrayList<MetodoEnvio> metodosEnvio) {
        this.metodosEnvio = metodosEnvio;
    }

    public MetodoPagamento getMetodoPagamentoById(int id){
        for(MetodoPagamento mp : metodosPagamento){
            if(mp.getId() == id){
                return mp;
            }
        }
        return null;
    }

    public MetodoEnvio getMetodoEnvioById(int id){
        for(MetodoEnvio me : metodosEnvio){
            if(me.getId() == id){
                return me;
            }
        }
        return null;
    }



    public static class MetodoPagamento {
        private int id;
        private String nome,logo;

        public MetodoPagamento(int id, String nome, String logo) {
            this.id = id;
            this.nome = nome;
            this.logo = logo;
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

        public String getLogo() {
            return logo;
        }

        public void setLogo(String logo) {
            this.logo = logo;
        }

    }

    public static class MetodoEnvio {
        private int id;
        private String nome;

        public MetodoEnvio(int id, String nome) {
            this.id = id;
            this.nome = nome;
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
    }


}
