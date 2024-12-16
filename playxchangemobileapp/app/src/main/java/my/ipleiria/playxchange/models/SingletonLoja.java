package my.ipleiria.playxchange.models;

import android.content.Context;
import android.content.SharedPreferences;
import android.util.Log;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonArrayRequest;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.UnsupportedEncodingException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

import my.ipleiria.playxchange.R;
import my.ipleiria.playxchange.listeners.CarrinhoListener;
import my.ipleiria.playxchange.listeners.CheckoutListener;
import my.ipleiria.playxchange.listeners.CodigoPromocionalListener;
import my.ipleiria.playxchange.listeners.FaturaListener;
import my.ipleiria.playxchange.listeners.FaturasListener;
import my.ipleiria.playxchange.listeners.JogoListener;
import my.ipleiria.playxchange.listeners.JogosListener;
import my.ipleiria.playxchange.listeners.LoginListener;
import my.ipleiria.playxchange.parsers.LojaJsonParser;
import my.ipleiria.playxchange.utils.Constants;

public class SingletonLoja {

    private static SingletonLoja instance = null;
    private static RequestQueue volleyQueue = null;
    private JogosListener jogosListener;

    private JogoListener jogoListener;

    private CarrinhoListener carrinhoListener;
    private FaturasListener faturasListener;

    private FaturaListener faturaListener;

    private LoginListener loginListener;

    private CodigoPromocionalListener codigoPromocionalListener;

    private CheckoutListener checkoutListener;



    private SingletonLoja(Context context) {
        volleyQueue = Volley.newRequestQueue(context);
        SharedPreferences sharedPreferences = context.getSharedPreferences(Constants.CURRENT_USER, Context.MODE_PRIVATE);
        String ip = sharedPreferences.getString(Constants.IP_ADDRESS, null);

        if (ip != null && !ip.equals(Constants.IP_ADDRESS)) {
            //Constants.IP_ADDRESS =  Constants.PROTOCOL + ip + ":" + Constants.PORT + "/" + Constants.PROJECT;
            Constants.IP_ADDRESS = Constants.PROTOCOL + ip + "/Projeto-SistemasInfor/playxchangewebapp/backend/web/api/";
        } else {
            Constants.IP_ADDRESS = Constants.PROTOCOL + "10.0.2.2/Projeto-SistemasInfor/playxchangewebapp/backend/web/api/";
        }
    }

    public static synchronized SingletonLoja getInstance(Context context) {
        if (instance == null) {
            instance = new SingletonLoja(context);
        }
        return instance;
    }

    public RequestQueue getVolleyQueue() {
        return volleyQueue;
    }

    //region - Listeners
    public void setJogosListener(JogosListener jogosListener) {
        this.jogosListener = jogosListener;
    }

    public void setLoginListener(LoginListener loginListener) {
        this.loginListener = loginListener;
    }

    public void setFaturaListener(FaturaListener faturaListener) {
        this.faturaListener = faturaListener;
    }

    public void setFaturasListener(FaturasListener faturasListener) {
        this.faturasListener = faturasListener;
    }

    public void setCarrinhoListener(CarrinhoListener carrinhoListener) {
        this.carrinhoListener = carrinhoListener;
    }

    public void setJogoListener(JogoListener jogoListener) {
        this.jogoListener = jogoListener;
    }

    public void setCodigoPromocionalListener(CodigoPromocionalListener codigoPromocionalListener){
        this.codigoPromocionalListener = codigoPromocionalListener;
    }
    public void setCheckoutListener(CheckoutListener checkoutListener){
        this.checkoutListener = checkoutListener;
    }
    //endregion



    //region - API

    //region - Account related API
    public void loginAPI(final String username, final String password, final Context context) {
        if (!LojaJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, R.string.txt_error_con, Toast.LENGTH_LONG).show();
        } else {
            StringRequest request = new StringRequest(Request.Method.POST, Constants.IP_ADDRESS + Constants.LOGIN_ENDPOINT, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    try {
                        JSONObject jsonObject = new JSONObject(response);
                        String token = jsonObject.getString("access_token");
                        if(!token.isEmpty()){
                            throw new JSONException("Token is empty");
                        }else{
                            if(loginListener != null){
                                loginListener.onLoginRefresh(token);
                            }
                        }
                    } catch (JSONException e) {
                        throw new RuntimeException(e);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    if (error.networkResponse != null && error.networkResponse.statusCode == 401) {
                        Toast.makeText(context, R.string.txt_error_authentication, Toast.LENGTH_LONG).show();
                    } else {
                        Toast.makeText(context, R.string.txt_error_request, Toast.LENGTH_LONG).show();
                    }
                }
            }){
                protected Map<String, String> getParams(){
                    Map<String, String> params = new HashMap<String, String>();
                    params.put("username", username);
                    params.put("password", password);

                    return params;

                }
            };
            volleyQueue.add(request);
        }
    }
    //endregion

    //region - Homepage related API

    public void getJogosByCategoriaAPI(final Context context, final String categoria) {
        if (!LojaJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, R.string.txt_error_con, Toast.LENGTH_LONG).show();
        } else {
            JsonArrayRequest req = new JsonArrayRequest(Request.Method.GET, Constants.IP_ADDRESS + "jogos/group/" + categoria, null, new Response.Listener<JSONArray>() {
                @Override
                public void onResponse(JSONArray response) {
                    ArrayList<Jogo> jogos = LojaJsonParser.parserJsonJogos(response);
                    if(jogosListener != null){
                        switch (categoria){
                            case "populares":
                                jogosListener.onRefreshListaJogosPopulares(jogos);
                                break;
                            case "recentes":
                                jogosListener.onRefreshListaJogosRecentes(jogos);
                                break;
                        }
                    }

                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, R.string.txt_error_request, Toast.LENGTH_LONG).show();
                }
            });
            volleyQueue.add(req);
        }
    }

    public void findJogoByIdAPI(final Context context, final int id,final String token) {
        if (!LojaJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, R.string.txt_error_con, Toast.LENGTH_LONG).show();
        } else {

            String url = Constants.IP_ADDRESS + "jogos/" + id;

            if (token != null) {
                url += "?access-token=" + token;
            }

            StringRequest req = new StringRequest(Request.Method.GET, url, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    Log.d("API Response", response);

                    Jogo jogo = LojaJsonParser.parserJsonJogo(response);
                    if(jogoListener != null){
                        jogoListener.onRefreshJogo(jogo);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    try {
                        String responseBody = new String(error.networkResponse.data, "utf-8");
                        JSONObject data = new JSONObject(responseBody);
                        String message = data.optString("msg");
                    } catch (JSONException e) {
                    } catch (UnsupportedEncodingException errorr) {
                    }
                    Toast.makeText(context, R.string.txt_error_request, Toast.LENGTH_LONG).show();
                }
            });
            volleyQueue.add(req);
        }
    }
    //endregion

    //region - Cart related API
    public void addProdutoCarrinhoAPI(final Context context, final int id, final int quantidade, String token) {
        if (!LojaJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, R.string.txt_error_con, Toast.LENGTH_LONG).show();
        } else {
            StringRequest req = new StringRequest(Request.Method.POST, Constants.IP_ADDRESS + "carrinhos/linhas/adicionar?access-token=" + token, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    if(jogoListener!=null){
                        jogoListener.onAddCarrinho();
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, R.string.txt_error_request, Toast.LENGTH_LONG).show();
                    Log.e("ERROR", error.toString());
                }
            }){
                protected Map<String, String> getParams(){
                    Map<String, String> params = new HashMap<String, String>();
                    params.put("produto_id", String.valueOf(id));
                    params.put("quantidade", String.valueOf(quantidade));

                    return params;

                }
            };
            volleyQueue.add(req);
        }
    }

    public void getCarrinhoAPI(final Context context, String token){
        if (!LojaJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, R.string.txt_error_con, Toast.LENGTH_LONG).show();
        } else {
            StringRequest req = new StringRequest(Request.Method.GET, Constants.IP_ADDRESS + "carrinhos?access-token=" + token, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    Carrinho carrinho = LojaJsonParser.parserJsonCarrinho(response);
                    if(carrinhoListener != null){
                        carrinhoListener.onRefreshCarrinho(carrinho);
                    }

                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, R.string.txt_error_request, Toast.LENGTH_LONG).show();
                    Log.e("ERROR", error.toString());
                }
            });
            volleyQueue.add(req);
        }
    }

    public void deleteProdutoCarrinhoAPI(final Context context, final int id, String token, Response.Listener<String> listener) {
        if (!LojaJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, R.string.txt_error_con, Toast.LENGTH_LONG).show();
        } else {
            StringRequest req = new StringRequest(Request.Method.DELETE, Constants.IP_ADDRESS + "carrinhos/linhas/" + Integer.toString(id) +  "?access-token=" + token, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    listener.onResponse(response);
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    String responseBody = null;
                    try {
                        responseBody = new String(error.networkResponse.data, "utf-8");
                    } catch (UnsupportedEncodingException e) {
                        throw new RuntimeException(e);
                    }
                    Toast.makeText(context, R.string.txt_error_request, Toast.LENGTH_LONG).show();
                    Log.e("ERROR", error.toString());
                }
            });
            volleyQueue.add(req);
        }
    }

    public void changeQuantityProdutoCarrinhoAPI(final Context context, final int id, final String token ,final int quantidade, String tipo, Response.Listener<String> listener) {
        if (!LojaJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, R.string.txt_error_con, Toast.LENGTH_LONG).show();
        } else {
            StringRequest req = new StringRequest(Request.Method.PUT, Constants.IP_ADDRESS + "carrinhos/linhas/" + Integer.toString(id) + "?access-token=" + token, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    listener.onResponse(response);
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    String responseBody = null;
                    try {
                        responseBody = new String(error.networkResponse.data, "utf-8");
                    } catch (UnsupportedEncodingException e) {
                        throw new RuntimeException(e);
                    }
                    Toast.makeText(context, R.string.txt_error_request, Toast.LENGTH_LONG).show();
                    Log.e("ERROR", error.toString());

                    Log.e("ERROR", responseBody);
                }
            }){
                protected Map<String, String> getParams(){
                    Map<String, String> params = new HashMap<String, String>();
                    params.put("quantidade", String.valueOf(quantidade));
                    params.put("tipo", tipo);
                    return params;

                }
            };
            volleyQueue.add(req);
        }
    }

    public void applyDescontoAPI(final Context context, final String token, final String codigo) {
        Log.e("SUCESS",codigo);
        if (!LojaJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, R.string.txt_error_con, Toast.LENGTH_LONG).show();
        } else {
            StringRequest req = new StringRequest(Request.Method.POST, Constants.IP_ADDRESS + "codigo-promocional/aplicar?access-token=" + token, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    CodigoPromocional codigoPromocional = LojaJsonParser.parserJsonCodigoPromocional(response);
                    if(codigoPromocionalListener!=null){
                        codigoPromocionalListener.onRefreshCodigo(codigoPromocional);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    String responseBody = null;
                    try {
                        responseBody = new String(error.networkResponse.data, "utf-8");
                    } catch (UnsupportedEncodingException e) {
                        throw new RuntimeException(e);
                    }
                    Toast.makeText(context, R.string.txt_error_request, Toast.LENGTH_LONG).show();
                    Log.e("ERROR", error.toString());

                    Log.e("ERROR", responseBody);
                }
            }){
                protected Map<String, String> getParams(){
                    Map<String, String> params = new HashMap<String, String>();
                    params.put("codigo", codigo);
                    return params;
                }
            };
            volleyQueue.add(req);
        }
    }


    //endregion

    //region - User interaction with games API

    public void addAvaliacaoAPI(final Context context, final int jogoId, final float avaliacao, String token) {
        if (!LojaJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, R.string.txt_error_con, Toast.LENGTH_LONG).show();
        } else {
            StringRequest req = new StringRequest(Request.Method.POST, Constants.IP_ADDRESS + "avaliacao/jogos?access-token=" + token, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    if(jogoListener!=null) {
                        jogoListener.onRatingCreated(avaliacao);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, R.string.txt_error_request, Toast.LENGTH_LONG).show();
                    Log.e("ERROR", error.toString());
                }
            }){
                protected Map<String, String> getParams(){
                    Map<String, String> params = new HashMap<String, String>();
                    params.put("jogo_id", String.valueOf(jogoId));
                    params.put("num_estrelas", String.valueOf(avaliacao));

                    return params;

                }
            };
            volleyQueue.add(req);
        }
    }

    public void updateAvaliacaoAPI(final Context context, final int jogoId, final float avaliacao, String token) {
        if (!LojaJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, R.string.txt_error_con, Toast.LENGTH_LONG).show();
        } else {
            StringRequest req = new StringRequest(Request.Method.PUT, Constants.IP_ADDRESS + "avaliacao/jogos/" + Integer.toString(jogoId) + "?access-token=" + token, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    if(jogoListener!=null) {
                        jogoListener.onRatingChanged(avaliacao);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, R.string.txt_error_request, Toast.LENGTH_LONG).show();
                }
            }){
                protected Map<String, String> getParams(){
                    Map<String, String> params = new HashMap<String, String>();
                    params.put("num_estrelas", String.valueOf(avaliacao));
                    return params;

                }
            };
            volleyQueue.add(req);
        }
    }

    public void deleteAvaliacaoAPI(final Context context, final int jogoId, String token) {
        if (!LojaJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, R.string.txt_error_con, Toast.LENGTH_LONG).show();
        } else {
            StringRequest req = new StringRequest(Request.Method.DELETE, Constants.IP_ADDRESS + "avaliacao/jogos/" + Integer.toString(jogoId) + "?access-token=" + token, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    if(jogoListener!=null) {
                        jogoListener.onRatingDeleted();
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    String responseBody = null;
                    try {
                        responseBody = new String(error.networkResponse.data, "utf-8");
                    } catch (UnsupportedEncodingException e) {
                        throw new RuntimeException(e);
                    }
                    Toast.makeText(context, R.string.txt_error_request, Toast.LENGTH_LONG).show();
                    Log.e("ERROR", error.toString());

                    Log.e("ERROR", responseBody);
                }
            });
            volleyQueue.add(req);
        }
    }

    public void interactJogoAPI(final Context context, final int jogoId, final String token, final int tipo) {
        if (!LojaJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, R.string.txt_error_con, Toast.LENGTH_LONG).show();
        } else {
            StringRequest req = new StringRequest(Request.Method.POST, Constants.IP_ADDRESS + "user/interagir?access-token=" + token, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    if(jogoListener!=null){
                        jogoListener.onInteract(tipo);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, R.string.txt_error_request, Toast.LENGTH_LONG).show();
                }
            }){
                protected Map<String, String> getParams(){
                    Map<String, String> params = new HashMap<String, String>();
                    params.put("jogo_id", String.valueOf(jogoId));
                    params.put("tipo", String.valueOf(tipo));
                    return params;
                }
            };
            volleyQueue.add(req);
        }
    }
    //endregion

    //region - Fatura related API
    public void getFaturasAPI(final Context context, final String token){
        if (!LojaJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, R.string.txt_error_con, Toast.LENGTH_LONG).show();
        } else {
            JsonArrayRequest req = new JsonArrayRequest(Request.Method.GET, Constants.IP_ADDRESS + "faturas?access-token=" + token, null, new Response.Listener<JSONArray>() {
                @Override
                public void onResponse(JSONArray response) {
                    ArrayList<Fatura> faturas = LojaJsonParser.parserJsonFaturas(response);
                    if(faturasListener != null){
                        faturasListener.onRefreshListaFaturas(faturas);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, R.string.txt_error_request, Toast.LENGTH_LONG).show();
                    Log.e("ERROR", error.toString());
                }
            });
            volleyQueue.add(req);
        }
    }

    public void getFaturaAPI(final Context context, final String token,final int id){
        if (!LojaJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, R.string.txt_error_con, Toast.LENGTH_LONG).show();
        } else {
            StringRequest req = new StringRequest(Request.Method.GET, Constants.IP_ADDRESS + "faturas/" + id + "?access-token=" + token, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    Fatura fatura = LojaJsonParser.parserJsonFatura(response);
                    if(faturaListener != null){
                        faturaListener.onRefreshFatura(fatura);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, R.string.txt_error_request, Toast.LENGTH_LONG).show();
                    Log.e("ERROR", error.toString());
                }
            });
            volleyQueue.add(req);
        }
    }

    public void checkoutAPI(final Context context,final String token, final int codigoId){
        if (!LojaJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, R.string.txt_error_con, Toast.LENGTH_LONG).show();
        }else{
            StringRequest req = new StringRequest(Request.Method.POST, Constants.IP_ADDRESS + "faturas/checkout?access-token=" + token, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    Checkout checkout = LojaJsonParser.parserJsonCheckout(response);
                    if(checkoutListener!=null){
                        checkoutListener.onRefreshCheckout(checkout);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    String responseBody = null;
                    try {
                        responseBody = new String(error.networkResponse.data, "utf-8");
                    } catch (UnsupportedEncodingException e) {
                        throw new RuntimeException(e);
                    }
                    Toast.makeText(context, R.string.txt_error_request, Toast.LENGTH_LONG).show();
                    Log.e("ERROR", error.toString());

                    Log.e("ERROR", responseBody);
                }
            }){
                protected Map<String, String> getParams(){
                    Map<String, String> params = new HashMap<String, String>();
                    params.put("codigo", String.valueOf(codigoId));
                    return params;
                }
            };
            volleyQueue.add(req);
        }
    }

    public void addFaturaAPI(final  Context context , final String token, final int metodoPagamentoId, final int metodoEnvioId, final int codigoId){
        if (!LojaJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, R.string.txt_error_con, Toast.LENGTH_LONG).show();
        }else{
            StringRequest req = new StringRequest(Request.Method.POST, Constants.IP_ADDRESS + "faturas?access-token=" + token, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    if(checkoutListener!=null) {
                        checkoutListener.onCheckoutSucess();
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    String body = "";
                    if (error.networkResponse != null && error.networkResponse.data != null) {
                        try {
                            body = new String(error.networkResponse.data, "UTF-8");

                            JSONObject jsonObject = new JSONObject(body);

                            if (jsonObject.has("message")) {
                                String errorMessage = jsonObject.getString("message");

                                Toast.makeText(context, errorMessage, Toast.LENGTH_LONG).show();
                            } else {
                            }
                        } catch (UnsupportedEncodingException | JSONException e) {
                            e.printStackTrace();
                        }
                    } else {
                    }

                }
            }){
                protected Map<String, String> getParams(){
                    Map<String, String> params = new HashMap<String, String>();
                    params.put("pagamento_id", String.valueOf(metodoPagamentoId));
                    params.put("envio_id", String.valueOf(metodoEnvioId));
                    params.put("codigo_id", String.valueOf(codigoId));
                    return params;
                }
            };
            volleyQueue.add(req);
        }
    }


    //endregion


    //endregion
}

