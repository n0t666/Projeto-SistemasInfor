package my.ipleiria.playxchange.parsers;

import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

import my.ipleiria.playxchange.models.Avaliacao;
import my.ipleiria.playxchange.models.Carrinho;
import my.ipleiria.playxchange.models.Checkout;
import my.ipleiria.playxchange.models.CodigoPromocional;
import my.ipleiria.playxchange.models.Fatura;
import my.ipleiria.playxchange.models.Jogo;
import my.ipleiria.playxchange.models.LinhaCarrinho;
import my.ipleiria.playxchange.models.User;

public class LojaJsonParser {
    public static boolean isConnectionInternet(Context context){
        ConnectivityManager cm = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo networkInfo = cm.getActiveNetworkInfo();
        return networkInfo != null && networkInfo.isConnectedOrConnecting();
    }

    public static ArrayList<Jogo> parserJsonJogos(JSONArray response){
        ArrayList<Jogo> jogos = new ArrayList<>();
        for (int i = 0; i < response.length(); i++) {
            try {
                JSONObject jsonJogo = response.getJSONObject(i);
                int id = jsonJogo.getInt("id");
                String nome = jsonJogo.getString("nome");
                String dataLancamento = jsonJogo.getString("dataLancamento");
                String capa = jsonJogo.getString("capa");

                Jogo auxJogo = new Jogo(
                        id,
                        nome,
                        null,
                        dataLancamento,
                        capa,
                        null,
                        null,
                        null,
                        null,
                        0,
                        0,
                        0.0,
                        0,
                        null,
                        null,
                        new ArrayList<>(),
                        new ArrayList<>(),
                        new ArrayList<>(),
                        new ArrayList<>()
                );

                jogos.add(auxJogo);

            } catch (JSONException e) {
                throw new RuntimeException(e);
            }

        }

        return jogos;
    }

    public static Jogo parserJsonJogo(String response){
        Jogo auxJogo = null;
        try {
            JSONObject jogo = new JSONObject(response);
            int id = jogo.has("id") && !jogo.isNull("id") ? jogo.getInt("id") : 0;
            String nome = jogo.has("nome") && !jogo.isNull("nome") ? jogo.getString("nome") : "";
            String descricao = jogo.has("descricao") && !jogo.isNull("descricao") ? jogo.getString("descricao") : "N/A";
            String dataLancamento = jogo.has("dataLancamento") && !jogo.isNull("dataLancamento") ? jogo.getString("dataLancamento") : "N/A";
            String capas = jogo.has("capa") && !jogo.isNull("capa") ? jogo.getString("capa") : "";
            String distribuidora = jogo.has("distribuidora") && !jogo.isNull("distribuidora") ? jogo.getString("distribuidora") : "";
            String editora = jogo.has("editora") && !jogo.isNull("editora") ? jogo.getString("editora") : "";
            String trailer = jogo.has("trailer") && !jogo.isNull("trailer") ? jogo.getString("trailer") : "";
            String franquia = jogo.has("franquia") && !jogo.isNull("franquia") ? jogo.getString("franquia") : "";
            int desejados = jogo.has("desejados") && !jogo.isNull("desejados") ? jogo.getInt("desejados") : 0;
            int jogados = jogo.has("jogados") && !jogo.isNull("jogados") ? jogo.getInt("jogados") : 0;
            double media = jogo.has("media") && !jogo.isNull("media") ? jogo.getDouble("media") : 0.0;
            int reviews = jogo.has("reviews") && !jogo.isNull("reviews") ? jogo.getInt("reviews") : 0;

            Avaliacao avaliacao = null;
            if (jogo.has("avaliacao") && !jogo.isNull("avaliacao")) {
                JSONObject jsonAvaliacao = jogo.getJSONObject("avaliacao");
                avaliacao = parserJsonAvaliacao(jsonAvaliacao);
            }

            Jogo.Atividade atividade = null;
            if (jogo.has("atividade") && !jogo.isNull("atividade")) {
                JSONObject jsonAtividade = jogo.getJSONObject("atividade");
                atividade = parserJsonAtividade(jsonAtividade);
            }else {
                atividade = new Jogo.Atividade(0, 0, 0, 0, 0, 0);
            }

            ArrayList<Jogo.Produto> produtos = new ArrayList<>();
            if (jogo.has("produtos")) {
                Object jsonProdutos = jogo.get("produtos");
                if (jsonProdutos instanceof JSONObject) {
                    JSONObject jsonProduto = (JSONObject) jsonProdutos;
                    Jogo.Produto produto = parserJsonProduto(jsonProduto);
                    produtos.add(produto);
                } else if (jsonProdutos instanceof JSONArray) {
                    JSONArray jsonProdutosArray = (JSONArray) jsonProdutos;
                    for (int i = 0; i < jsonProdutosArray.length(); i++) {
                        JSONObject jsonProduto = jsonProdutosArray.getJSONObject(i);
                        Jogo.Produto produto = parserJsonProduto(jsonProduto);
                        produtos.add(produto);
                    }
                }
            }


            ArrayList<Jogo.Tag> tags = new ArrayList<>();
            if (jogo.has("tags")) {
                Object jsonTags = jogo.get("tags");
                if (jsonTags instanceof JSONObject) {
                    JSONObject jsonTag = (JSONObject) jsonTags;
                    Jogo.Tag tag = parserJsonTag(jsonTag);
                    tags.add(tag);
                } else if (jsonTags instanceof JSONArray) {
                    JSONArray jsonTagArray = (JSONArray) jsonTags;
                    for (int i = 0; i < jsonTagArray.length(); i++) {
                        JSONObject jsonTag = jsonTagArray.getJSONObject(i);
                        Jogo.Tag tag = parserJsonTag(jsonTag);
                        tags.add(tag);
                    }
                }
            }

            ArrayList<Jogo.Genero> generos = new ArrayList<>();
            if (jogo.has("generos")) {
                Object jsonGeneros = jogo.get("generos");
                if (jsonGeneros instanceof JSONObject) {
                    JSONObject jsonGenero = (JSONObject) jsonGeneros;
                    Jogo.Genero genero = parserJsonGenero(jsonGenero);
                    generos.add(genero);
                } else if (jsonGeneros instanceof JSONArray) {
                    JSONArray jsonGenerosArray = (JSONArray) jsonGeneros;
                    for (int i = 0; i < jsonGenerosArray.length(); i++) {
                        JSONObject jsonGenero = jsonGenerosArray.getJSONObject(i);
                        Jogo.Genero genero = parserJsonGenero(jsonGenero);
                        generos.add(genero);
                    }
                }
            }


            ArrayList<String> screenshots = new ArrayList<>();
            if (jogo.has("screenshots")) {
                Object jsonScreenshots = jogo.get("screenshots");
                if (jsonScreenshots instanceof String) {
                    screenshots.add((String) jsonScreenshots);
                } else if (jsonScreenshots instanceof JSONArray) {
                    JSONArray jsonScreenshotsArray = (JSONArray) jsonScreenshots;
                    for (int i = 0; i < jsonScreenshotsArray.length(); i++) {
                        screenshots.add(jsonScreenshotsArray.getString(i));
                    }
                }
            }

            auxJogo = new Jogo(id, nome, descricao, dataLancamento, capas, distribuidora, editora, trailer, franquia, desejados, jogados, media, reviews, avaliacao, atividade, produtos, tags, generos, screenshots);

        } catch (JSONException e) {
            throw new RuntimeException(e);
        }

        return auxJogo;
    }

    public static Jogo.Atividade parserJsonAtividade(JSONObject jsonAtividade) {
        try {
            int id = jsonAtividade.getInt("id");
            int utilizadorId = jsonAtividade.getInt("utilizador_id");
            int jogoId = jsonAtividade.getInt("jogo_id");
            int isJogado = jsonAtividade.getInt("isJogado");
            int isDesejado = jsonAtividade.getInt("isDesejado");
            int isFavorito = jsonAtividade.getInt("isFavorito");

            return new Jogo.Atividade(id, utilizadorId, jogoId, isJogado, isDesejado, isFavorito);
        } catch (JSONException e) {
            throw new RuntimeException(e);
        }
    }

    public static Jogo.Produto parserJsonProduto(JSONObject jsonProduto) {
        try {
            int id = jsonProduto.getInt("id");
            String plataformaNome = jsonProduto.getString("plataformaNome");
            int plataformaId = jsonProduto.getInt("plataformaId");
            double preco = jsonProduto.getDouble("preco");
            int quantidade = jsonProduto.getInt("quantidade");

            return new Jogo.Produto(id, plataformaNome, plataformaId, preco, quantidade);
        } catch (JSONException e) {
            throw new RuntimeException(e);
        }
    }

    public static Jogo.Tag parserJsonTag(JSONObject jsonTag) {
        try {
            int id = jsonTag.getInt("id");
            String nome = jsonTag.getString("nome");
            return new Jogo.Tag(id, nome);
        } catch (JSONException e) {
            throw new RuntimeException(e);
        }
    }

    public static Jogo.Genero parserJsonGenero(JSONObject jsonGenero) {
        try {
            int id = jsonGenero.getInt("id");
            String nome = jsonGenero.getString("nome");

            return new Jogo.Genero(id, nome);
        } catch (JSONException e) {
            throw new RuntimeException(e);
        }
    }

    public static Avaliacao parserJsonAvaliacao(JSONObject jsonAvaliacao) {
        try {
            int jogoId = jsonAvaliacao.getInt("jogo_id");
            int utilizadorId = jsonAvaliacao.getInt("utilizador_id");
            double numEstrelas = jsonAvaliacao.getDouble("numEstrelas");
            String dataAvaliacao = jsonAvaliacao.getString("dataAvaliacao");
            return new Avaliacao(jogoId, utilizadorId, numEstrelas, dataAvaliacao);
        } catch (JSONException e) {
            throw new RuntimeException(e);
        }
    }

    public static Carrinho parserJsonCarrinho(String response){
        Carrinho auxCarrinho = null;
        try {
            JSONObject jsonObject = new JSONObject(response);
            JSONObject carrinho = jsonObject.getJSONObject("carrinho");
            int id = carrinho.has("id") && !carrinho.isNull("id") ? carrinho.getInt("id") : 0;
            int quantidade = carrinho.has("quantidade") && !carrinho.isNull("quantidade") ? carrinho.getInt("quantidade") : 0;
            double total = carrinho.has("total") && !carrinho.isNull("total") ? carrinho.getDouble("total") : 0.0;
            ArrayList<LinhaCarrinho> itensCarrinho = new ArrayList<>();
            if (jsonObject.has("itensCarrinho") && !jsonObject.isNull("itensCarrinho")) {
                JSONArray jsonItensCarrinho = jsonObject.getJSONArray("itensCarrinho");
                for (int i = 0; i < jsonItensCarrinho.length(); i++) {
                    JSONObject jsonLinhasCarrinho = jsonItensCarrinho.getJSONObject(i);
                    int produtoId = jsonLinhasCarrinho.has("produto_id") && !jsonLinhasCarrinho.isNull("produto_id") ? jsonLinhasCarrinho.getInt("produto_id") : 0;
                    String produtoNome = jsonLinhasCarrinho.has("produto_nome") && !jsonLinhasCarrinho.isNull("produto_nome") ? jsonLinhasCarrinho.getString("produto_nome") : "";
                    int quantidadeProduto = jsonLinhasCarrinho.has("quantidade") && !jsonLinhasCarrinho.isNull("quantidade") ? jsonLinhasCarrinho.getInt("quantidade") : 0;
                    double preco = jsonLinhasCarrinho.has("preco") && !jsonLinhasCarrinho.isNull("preco") ? jsonLinhasCarrinho.getDouble("preco") : 0.0;
                    String imagem = jsonLinhasCarrinho.has("capa") && !jsonLinhasCarrinho.isNull("capa") ? jsonLinhasCarrinho.getString("capa") : "";
                    double totalProduto = jsonLinhasCarrinho.has("total") && !jsonLinhasCarrinho.isNull("total") ? jsonLinhasCarrinho.getDouble("total") : 0.0;
                    String plataforma = jsonLinhasCarrinho.has("plataforma_nome") && !jsonLinhasCarrinho.isNull("plataforma_nome") ? jsonLinhasCarrinho.getString("plataforma_nome") : "";
                    LinhaCarrinho linhaCarrinho = new LinhaCarrinho(produtoId, produtoNome, quantidadeProduto, preco, imagem, totalProduto, plataforma);
                    itensCarrinho.add(linhaCarrinho);
                }
                auxCarrinho = new Carrinho(total, id, quantidade, itensCarrinho);
            }
        } catch (JSONException e) {
            throw new RuntimeException(e);
        }

        return auxCarrinho;
    }

    public static ArrayList<Fatura> parserJsonFaturas(JSONArray response){
        ArrayList<Fatura> faturas = new ArrayList<>();
        for (int i = 0; i < response.length(); i++) {
            try {
                JSONObject jsonFatura = response.getJSONObject(i);
                int id = jsonFatura.has("id") && !jsonFatura.isNull("id") ? jsonFatura.getInt("id") : 0;
                String data = jsonFatura.has("dataEncomenda") && !jsonFatura.isNull("dataEncomenda") ? jsonFatura.getString("dataEncomenda") : "";
                double total = jsonFatura.has("total") && !jsonFatura.isNull("total") ? jsonFatura.getDouble("total") : 0.0;
                double totalSemDesconto = jsonFatura.has("totalSemDesconto") && !jsonFatura.isNull("totalSemDesconto") ? jsonFatura.getDouble("totalSemDesconto") : 0.0;
                double quantidadeDesconto = jsonFatura.has("quantidadeDesconto") && !jsonFatura.isNull("quantidadeDesconto") ? jsonFatura.getDouble("quantidadeDesconto") : 0.0;
                int estado = jsonFatura.has("estado") && !jsonFatura.isNull("estado") ? jsonFatura.getInt("estado") : -1;
                int quantidade = jsonFatura.has("quantidade") && !jsonFatura.isNull("quantidade") ? jsonFatura.getInt("quantidade") : 0;
                ArrayList <String> capasPreview = new ArrayList<>();
                if (jsonFatura.has("imagensJogos") && !jsonFatura.isNull("imagensJogos")) {
                    JSONArray jsonCapasPreview = jsonFatura.getJSONArray("imagensJogos");
                    for (int j = 0; j < jsonCapasPreview.length(); j++) {
                        capasPreview.add(jsonCapasPreview.getString(j));
                    }
                }

                Fatura auxFatura = new Fatura(id,quantidade, Fatura.EstadoFatura.getEstadoFromNum(estado),null,null,null,data,total,  new ArrayList<>(),capasPreview,totalSemDesconto,quantidadeDesconto);
                faturas.add(auxFatura);

            } catch (JSONException e) {
                throw new RuntimeException(e);
            }
        }
        return faturas;
    }

    public static Fatura parserJsonFatura(String response) {
        Fatura auxFatura = null;
        try {
            JSONObject jsonObject = new JSONObject(response);
            JSONObject jsonFatura = jsonObject.getJSONObject("fatura");

            int id = jsonFatura.has("id") && !jsonFatura.isNull("id") ? jsonFatura.getInt("id") : 0;
            String totalString = jsonFatura.has("total") && !jsonFatura.isNull("total") ? jsonFatura.getString("total") : "0,00 €";
            double total = jsonFatura.has("total") && !jsonFatura.isNull("total") ? jsonFatura.getDouble("total") : 0.0;
            double totalSemDesconto = jsonFatura.has("totalSemDesconto") && !jsonFatura.isNull("totalSemDesconto") ? jsonFatura.getDouble("totalSemDesconto") : 0.0;
            double quantidadeDesconto = jsonFatura.has("quantidadeDesconto") && !jsonFatura.isNull("quantidadeDesconto") ? jsonFatura.getDouble("quantidadeDesconto") : 0.0;
            String data = jsonFatura.has("dataEncomenda") && !jsonFatura.isNull("dataEncomenda") ? jsonFatura.getString("dataEncomenda") : "";
            String pagamento = jsonFatura.has("pagamento") && !jsonFatura.isNull("pagamento") ? jsonFatura.getString("pagamento") : "";
            String envio = jsonFatura.has("envio") && !jsonFatura.isNull("envio") ? jsonFatura.getString("envio") : "";
            String codigo = jsonFatura.has("codigo") && !jsonFatura.isNull("codigo") ? jsonFatura.getString("codigo") : "";
            int totalItens = jsonFatura.has("count") && !jsonFatura.isNull("count") ? jsonFatura.getInt("count") : 0;
            int estado = jsonFatura.has("estado") && !jsonFatura.isNull("estado") ? jsonFatura.getInt("estado") : -1;


            ArrayList<Fatura.LinhaFatura> linhasFatura = new ArrayList<>();
            if (jsonObject.has("linhasFatura") && !jsonObject.isNull("linhasFatura")) {
                JSONArray jsonLinhasFatura = jsonObject.getJSONArray("linhasFatura");
                for (int i = 0; i < jsonLinhasFatura.length(); i++) {
                    JSONObject jsonLinhaFatura = jsonLinhasFatura.getJSONObject(i);
                    int jogoId = jsonLinhaFatura.has("jogoId") && !jsonLinhaFatura.isNull("jogoId") ? jsonLinhaFatura.getInt("jogoId") : 0;
                    String produtoNome = jsonLinhaFatura.has("produtoNome") && !jsonLinhaFatura.isNull("produtoNome") ? jsonLinhaFatura.getString("produtoNome") : "";
                    int quantidadeProduto = jsonLinhaFatura.has("quantidade") && !jsonLinhaFatura.isNull("quantidade") ? jsonLinhaFatura.getInt("quantidade") : 0;
                    double preco = jsonLinhaFatura.has("precoUnitario") && !jsonLinhaFatura.isNull("precoUnitario") ? jsonLinhaFatura.getDouble("precoUnitario") : 0.0;
                    String imagem = jsonLinhaFatura.has("capa") && !jsonLinhaFatura.isNull("capa") ? jsonLinhaFatura.getString("capa") : "";
                    double totalProduto = jsonLinhaFatura.has("subtotal") && !jsonLinhaFatura.isNull("subtotal") ? jsonLinhaFatura.getDouble("subtotal") : 0.0;
                    String plataforma = jsonLinhaFatura.has("plataforma") && !jsonLinhaFatura.isNull("plataforma") ? jsonLinhaFatura.getString("plataforma") : "";

                    ArrayList<String> chaves = new ArrayList<>();
                    if (jsonLinhaFatura.has("chaves") && !jsonLinhaFatura.isNull("chaves")) {
                        JSONArray jsonChaves = jsonLinhaFatura.getJSONArray("chaves");
                        for (int j = 0; j < jsonChaves.length(); j++) {
                            String chave = jsonChaves.getString(j);
                            chaves.add(chave);
                        }
                    }

                    Fatura.LinhaFatura linhaFatura = new Fatura.LinhaFatura(jogoId,produtoNome,quantidadeProduto,imagem,preco,chaves,plataforma,totalProduto);
                    linhasFatura.add(linhaFatura);
                }
            }

            auxFatura = new Fatura(id,totalItens,Fatura.EstadoFatura.getEstadoFromNum(estado),pagamento,envio,codigo,data,total,linhasFatura,null,totalSemDesconto,quantidadeDesconto);
        } catch (JSONException e) {
            e.printStackTrace();
        }
        return auxFatura;
    }


    public static CodigoPromocional parserJsonCodigoPromocional(String response){
        CodigoPromocional auxCodigo = null;
        try {
            JSONObject codigo = new JSONObject(response);
            int id = codigo.has("id") && !codigo.isNull("id") ? codigo.getInt("id") : 0;
            int status = codigo.has("status") && !codigo.isNull("status") ? codigo.getInt("status") : 0;
            int desconto =  codigo.has("desconto") && !codigo.isNull("desconto") ? codigo.getInt("desconto") : 0;
            double valorDescontado = codigo.has("valorDescontado") && !codigo.isNull("valorDescontado") ? codigo.getDouble("valorDescontado") : 0.0;
            String codigoName = codigo.has("codigo") && !codigo.isNull("codigo") ? codigo.getString("codigo") : "";
            auxCodigo = new CodigoPromocional(id,status,desconto,codigoName,valorDescontado);
        } catch (JSONException e) {
            throw new RuntimeException(e);
        }
        return auxCodigo;
    }

    public static Checkout parserJsonCheckout(String response){
        Checkout auxCheckout = null;
        try {
            JSONObject checkout = new JSONObject(response);
            double total = checkout.has("total") && !checkout.isNull("total") ? checkout.getDouble("total") : 0.0;
            double totalSemDesconto = checkout.has("totalSemDesconto") && !checkout.isNull("totalSemDesconto") ? checkout.getDouble("totalSemDesconto") : 0.0;
            double valorDesconto = checkout.has("valorDescontado") && !checkout.isNull("valorDescontado") ? checkout.getDouble("valorDescontado") : 0.0;
            String codigo ="";
            int codigoId = -1;
            String logo = "";
            if(checkout.has("codigo") && !checkout.isNull("codigo")){
                JSONObject jsonCodigo = checkout.getJSONObject("codigo");
                codigo = jsonCodigo.has("codigo") && !jsonCodigo.isNull("codigo") ? jsonCodigo.getString("codigo") : "";
                codigoId = jsonCodigo.has("id") && !jsonCodigo.isNull("id") ? jsonCodigo.getInt("id") : -1;
            }
            ArrayList<Checkout.MetodoPagamento> metodosPagamento = new ArrayList<>();
            if(checkout.has("metodosPagamento") && !checkout.isNull("metodosPagamento")){
                JSONArray jsonMetodosPagamento = checkout.getJSONArray("metodosPagamento");
                for (int i = 0; i < jsonMetodosPagamento.length(); i++) {
                    JSONObject jsonMetodoPagamento = jsonMetodosPagamento.getJSONObject(i);
                    int id = jsonMetodoPagamento.has("id") && !jsonMetodoPagamento.isNull("id") ? jsonMetodoPagamento.getInt("id") : 0;
                    String nome = jsonMetodoPagamento.has("nome") && !jsonMetodoPagamento.isNull("nome") ? jsonMetodoPagamento.getString("nome") : "";
                    String logotipo = jsonMetodoPagamento.has("logotipo") && !jsonMetodoPagamento.isNull("logotipo") ? jsonMetodoPagamento.getString("logotipo") : "";
                    Checkout.MetodoPagamento metodoPagamento = new Checkout.MetodoPagamento(id,nome,logotipo);
                    metodosPagamento.add(metodoPagamento);
                }
            }

            ArrayList<Checkout.MetodoEnvio> metodosEnvio = new ArrayList<>();
            if(checkout.has("metodosEnvio") && !checkout.isNull("metodosEnvio")){
                JSONArray jsonMetodosEnvio = checkout.getJSONArray("metodosEnvio");
                for (int i = 0; i < jsonMetodosEnvio.length(); i++) {
                    JSONObject jsonMetodoEnvio = jsonMetodosEnvio.getJSONObject(i);
                    int id = jsonMetodoEnvio.has("id") && !jsonMetodoEnvio.isNull("id") ? jsonMetodoEnvio.getInt("id") : 0;
                    String nome = jsonMetodoEnvio.has("nome") && !jsonMetodoEnvio.isNull("nome") ? jsonMetodoEnvio.getString("nome") : "";
                    Checkout.MetodoEnvio metodoEnvio = new Checkout.MetodoEnvio(id,nome);
                    metodosEnvio.add(metodoEnvio);
                }
            }
            auxCheckout = new Checkout(codigoId,total,totalSemDesconto,valorDesconto,codigo,metodosPagamento,metodosEnvio);
        } catch (JSONException e) {
            throw new RuntimeException(e);
        }
        return auxCheckout;
    }

    public static User parserJsonUser(String response){
        User auxUser = null;
        try {
            JSONObject user = new JSONObject(response);
            String username = user.has("username") && !user.isNull("username") ? user.getString("username") : "";
            String email = user.has("email") && !user.isNull("email") ? user.getString("email") : "";
            String nome = user.has("nome") && !user.isNull("nome") ? user.getString("nome") : "";
            String dataNascimento = user.has("dataNascimento") && !user.isNull("dataNascimento") ? user.getString("dataNascimento") : "";
            String biografia = user.has("biografia") && !user.isNull("biografia") ? user.getString("biografia") : "";
            String fotoCapa = user.has("fotoCapa") && !user.isNull("fotoCapa") ? user.getString("fotoCapa") : "";
            String fotoPerfil = user.has("fotoPerfil") && !user.isNull("fotoPerfil") ? user.getString("fotoPerfil") : "";
            String nif = user.has("nif") && !user.isNull("nif") ? user.getString("nif") : "";
            int privacidadeSeguidores = user.has("privacidadeSeguidores") && !user.isNull("privacidadeSeguidores") ? user.getInt("privacidadeSeguidores") : 0;
            int privacidadeJogos = user.has("privacidadeJogos") && !user.isNull("privacidadeJogos") ? user.getInt("privacidadeJogos") : 0;
            int privacidadePerfil = user.has("privacidadePerfil") && !user.isNull("privacidadePerfil") ? user.getInt("privacidadePerfil") : 0;
            int numReviews = user.has("numReviews") && !user.isNull("numReviews") ? user.getInt("numReviews") : 0;
            int numSeguidores = user.has("numSeguidores") && !user.isNull("numSeguidores") ? user.getInt("numSeguidores") : 0;
            int numSeguir = user.has("numSeguir") && !user.isNull("numSeguir") ? user.getInt("numSeguir") : 0;
            int numJogados = user.has("numJogados") && !user.isNull("numJogados") ? user.getInt("numJogados") : 0;
            int numFavoritos = user.has("numFavoritos") && !user.isNull("numFavoritos") ? user.getInt("numFavoritos") : 0;
            int numDesejados = user.has("numDesejados") && !user.isNull("numDesejados") ? user.getInt("numDesejados") : 0;
            ArrayList<Jogo> favoritosPreview = new ArrayList<>();
            if (user.has("previewFavoritos") && !user.isNull("previewFavoritos")) {
                JSONArray jsonFavoritosPreview = user.getJSONArray("previewFavoritos");
                for (int i = 0; i < jsonFavoritosPreview.length(); i++) {
                    JSONObject jsonFavorito = jsonFavoritosPreview.getJSONObject(i);
                    int id = jsonFavorito.has("id") && !jsonFavorito.isNull("id") ? jsonFavorito.getInt("id") : 0;
                    String capa = jsonFavorito.has("capa") && !jsonFavorito.isNull("capa") ? jsonFavorito.getString("capa") : "";
                    Jogo jogo = new Jogo(id,null,null,null,capa,null,null,null,null,0,0,0.0,0,null,null,null,null,null,null);
                    favoritosPreview.add(jogo);
                }
            }
            auxUser = new User(biografia,0,nome,nif,dataNascimento,fotoCapa,fotoPerfil,username,email,numSeguidores,numSeguir,numJogados,numFavoritos,numDesejados,favoritosPreview);
        } catch (JSONException e) {
            throw new RuntimeException(e);
        }
        return auxUser;

    }







}
