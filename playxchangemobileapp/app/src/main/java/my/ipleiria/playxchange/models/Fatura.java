package my.ipleiria.playxchange.models;

import java.util.ArrayList;
import java.util.List;

import my.ipleiria.playxchange.R;

public class Fatura {

    private int id, totalItens;
    private String pagamento, envio, codigo, dataPagamento;
    private double total,totalSemDesconto,quantidadeDesconto;
    private ArrayList<LinhaFatura> linhasFatura;
    private ArrayList<String> capasPreview;
    private EstadoFatura estado;


    public enum EstadoFatura {
        DESCONHECIDO(-1,"Desconhecido", R.color.estado_unknown),
        PENDENTE(1,"Pendente", R.color.estado_pending),
        PAGO(2,"Pago", R.color.estado_paid),
        ENVIADO(3,"Enviado", R.color.estado_shipped),
        ENTREGUE(4,"Entregue", R.color.estado_delivered),
        COMPLETO(5,"Completo", R.color.estado_completed),
        CANCELADO(6,"Cancelado", R.color.estado_cancelled),
        REEMBOLSADO(7,"Reembolsado", R.color.estado_refunded),;

        private final int estado;
        private final String estadoNome;
        private final int cor;

        EstadoFatura(int estado, String estadoNome,int cor) {
            this.estado = estado;
            this.estadoNome = estadoNome;
            this.cor = cor;
        }

        public String getEstadoNome() {
            return estadoNome;
        }

        public int getEstado() {
            return estado;
        }

        public int getCor() {
            return cor;
        }

        public static EstadoFatura getEstadoFromNum(int estado){
            for(EstadoFatura e : EstadoFatura.values()){
                if(e.getEstado() == estado){
                    return e;
                }
            }
            return null;
        }

        public static EstadoFatura getEstadoFromNome(String estadoNome){
            for(EstadoFatura e : EstadoFatura.values()){
                if(e.getEstadoNome().equals(estadoNome)){
                    return e;
                }
            }
            return null;
        }
    }

    public double getQuantidadeDesconto() {
        return quantidadeDesconto;
    }

    public void setQuantidadeDesconto(double quantidadeDesconto) {
        this.quantidadeDesconto = quantidadeDesconto;
    }

    public double getTotalSemDesconto() {
        return totalSemDesconto;
    }

    public void setTotalSemDesconto(double totalSemDesconto) {
        this.totalSemDesconto = totalSemDesconto;
    }

    public Fatura(int id, int totalItens, EstadoFatura estado, String pagamento, String envio, String codigo, String dataPagamento, double total, ArrayList<LinhaFatura> linhasFatura, ArrayList<String> capasPreview, double totalSemDesconto, double quantidadeDesconto) {
        this.id = id;
        this.totalItens = totalItens;
        this.estado = estado;
        this.pagamento = pagamento;
        this.envio = envio;
        this.codigo = codigo;
        this.dataPagamento = dataPagamento;
        this.total = total;
        this.linhasFatura = linhasFatura;
        this.capasPreview = capasPreview;
        this.totalSemDesconto = totalSemDesconto;
        this.quantidadeDesconto = quantidadeDesconto;

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

    public EstadoFatura getEstado() {
        return estado;
    }

    public void setEstado(EstadoFatura estado) {
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

    public ArrayList<LinhaFatura> getLinhasFatura() {
        return linhasFatura;
    }

    public void setLinhasFatura(ArrayList<LinhaFatura> linhasFatura) {
        this.linhasFatura = linhasFatura;
    }


    public ArrayList<String> getCapasPreview() {
        return capasPreview;
    }

    public void setCapasPreview(ArrayList<String> capasPreview) {
        this.capasPreview = capasPreview;
    }

    public static class LinhaFatura {
        private int idJogo, quantidade;
        private double preco,subtotal;
        private String nome, imagem, plataforma;
        private ArrayList<String> chaves;

        public LinhaFatura(int idJogo, String nome, int quantidade, String imagem, double preco, ArrayList<String> chaves, String plataforma, double subtotal) {
            this.idJogo = idJogo;
            this.nome = nome;
            this.quantidade = quantidade;
            this.imagem = imagem;
            this.preco = preco;
            this.chaves = chaves;
            this.plataforma = plataforma;
            this.subtotal = subtotal;
        }

        public int getIdJogo() {
            return idJogo;
        }

        public void setIdJogo(int idJogo) {
            this.idJogo = idJogo;
        }

        public int getQuantidade() {
            return quantidade;
        }

        public void setQuantidade(int quantidade) {
            this.quantidade = quantidade;
        }

        public double getPreco() {
            return preco;
        }

        public void setPreco(double preco) {
            this.preco = preco;
        }

        public String getNome() {
            return nome;
        }

        public void setNome(String nome) {
            this.nome = nome;
        }

        public String getImagem() {
            return imagem;
        }

        public void setImagem(String imagem) {
            this.imagem = imagem;
        }

        public String getPlataforma() {
            return plataforma;
        }

        public void setPlataforma(String plataforma) {
            this.plataforma = plataforma;
        }

        public ArrayList<String> getChaves() {
            return chaves;
        }

        public void setChaves(ArrayList<String> chaves) {
            this.chaves = chaves;
        }

        public double getSubtotal() {
            return subtotal;
        }

        public void setSubtotal(double subtotal) {
            this.subtotal = subtotal;
        }
    }
}
