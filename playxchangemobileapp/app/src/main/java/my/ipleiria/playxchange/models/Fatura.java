package my.ipleiria.playxchange.models;

public class Fatura {
    private int id,totalItens,estado;
    private String pagamento,envio,codigo,dataPagamento;
    private double total;

    public Fatura(int id, int totalItens, int estado, String pagamento, String envio, String codigo, String dataPagamento, double total) {
        this.id = id;
        this.totalItens = totalItens;
        this.estado = estado;
        this.pagamento = pagamento;
        this.envio = envio;
        this.codigo = codigo;
        this.dataPagamento = dataPagamento;
        this.total = total;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getTotalItens() {
        return totalItens;
    }

    public void setTotalItens(int totalItens) {
        this.totalItens = totalItens;
    }

    public int getEstado() {
        return estado;
    }

    public void setEstado(int estado) {
        this.estado = estado;
    }

    public String getPagamento() {
        return pagamento;
    }

    public void setPagamento(String pagamento) {
        this.pagamento = pagamento;
    }

    public String getEnvio() {
        return envio;
    }

    public void setEnvio(String envio) {
        this.envio = envio;
    }

    public String getCodigo() {
        return codigo;
    }

    public void setCodigo(String codigo) {
        this.codigo = codigo;
    }

    public String getDataPagamento() {
        return dataPagamento;
    }

    public void setDataPagamento(String dataPagamento) {
        this.dataPagamento = dataPagamento;
    }

    public double getTotal() {
        return total;
    }

    public void setTotal(double total) {
        this.total = total;
    }
}
