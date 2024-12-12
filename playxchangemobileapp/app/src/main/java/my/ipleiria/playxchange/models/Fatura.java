package my.ipleiria.playxchange.models;

import java.util.List;

public class Fatura {
    private int id, totalItens;
    private String pagamento, envio, codigo, dataPagamento,estado;
    private double total;
    private List<LinhaFatura> linhasFatura;
    private List<String> capasPreview;

    public Fatura(int id, int totalItens, String estado, String pagamento, String envio, String codigo, String dataPagamento, double total, List<LinhaFatura> linhasFatura, List<String> capasPreview) {
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

    public String getEstado() {
        return estado;
    }

    public void setEstado(String estado) {
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

    public List<LinhaFatura> getLinhasFatura() {
        return linhasFatura;
    }

    public void setLinhasFatura(List<LinhaFatura> linhasFatura) {
        this.linhasFatura = linhasFatura;
    }

    public List<String> getCapasPreview() {
        return capasPreview;
    }

    public void setCapasPreview(List<String> capasPreview) {
        this.capasPreview = capasPreview;
    }

    public static class LinhaFatura {
        private int id, idProduto, quantidade;
        private double preco,subtotal;
        private String nome, imagem, plataforma;
        private List<String> chaves;

        public LinhaFatura(int id, int idProduto, String nome, int quantidade, String imagem, double preco, List<String> chaves, String plataforma, double subtotal) {
            this.id = id;
            this.idProduto = idProduto;
            this.nome = nome;
            this.quantidade = quantidade;
            this.imagem = imagem;
            this.preco = preco;
            this.chaves = chaves;
            this.plataforma = plataforma;
            this.subtotal = subtotal;
        }

        public int getId() {
            return id;
        }

        public void setId(int id) {
            this.id = id;
        }

        public int getIdProduto() {
            return idProduto;
        }

        public void setIdProduto(int idProduto) {
            this.idProduto = idProduto;
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

        public List<String> getChaves() {
            return chaves;
        }

        public void setChaves(List<String> chaves) {
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
