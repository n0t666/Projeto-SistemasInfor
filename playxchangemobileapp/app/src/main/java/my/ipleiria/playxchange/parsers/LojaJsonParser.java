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
import my.ipleiria.playxchange.models.Jogo;
import my.ipleiria.playxchange.models.LinhaCarrinho;

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
            }

            List<Jogo.Produto> produtos = new ArrayList<>();
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


            List<Jogo.Tag> tags = new ArrayList<>();
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

            List<Jogo.Genero> generos = new ArrayList<>();
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


            List<String> screenshots = new ArrayList<>();
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
            List<LinhaCarrinho> itensCarrinho = new ArrayList<>();
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






}
