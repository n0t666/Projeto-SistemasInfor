package my.ipleiria.playxchange.models;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;
import android.text.TextUtils;

import androidx.annotation.Nullable;

import java.util.ArrayList;
import java.util.List;

public class LojaBDHelper extends SQLiteOpenHelper
{
    private static final String DB_NAME= "bdLoja";

    // Tabelas
    private static final String TABLE_JOGOS = "Jogos";
    private static final String TABLE_PRODUTOS = "Produtos";
    private static final String TABLE_DESEJADOS = "Desejados";
    private static final String TABLE_SCREENSHOTS = "Screenshots";

    // Colunas
    private static final String COLUMN_ID = "id";
    private static final String COLUMN_NOME = "nome";
    private static final String COLUMN_DESCRICAO = "descricao";
    private static final String COLUMN_DATA_LANCAMENTO = "dataLancamento";
    private static final String COLUMN_CAPAS = "capas";
    private static final String COLUMN_DISTRIBUIDORA = "distribuidora";
    private static final String COLUMN_EDITORA = "editora";
    private static final String COLUMN_TRAILER = "trailer";
    private static final String COLUMN_FRANQUIA = "franquia";
    private static final String COLUMN_DESEJADOS = "desejados";
    private static final String COLUMN_REVIEWS = "reviews";
    private static final String COLUMN_JOGADOS = "jogados";
    private static final String COLUMN_MEDIA = "media";
    private static final String COLUMN_PRECO = "preco";
    private static final String COLUMN_JOGO_ID = "jogo_id";
    private static final String COLUMN_FILENAME = "filename";


    private final SQLiteDatabase db;

    public LojaBDHelper(@Nullable Context context) {
        super(context, DB_NAME, null, 1);
        this.db = getWritableDatabase();
    }

    @Override
    public void onCreate(SQLiteDatabase db) {
        String createJogosTable = "CREATE TABLE " + TABLE_JOGOS + " (" +
                COLUMN_ID + " INTEGER PRIMARY KEY , " +
                COLUMN_NOME + " TEXT, " +
                COLUMN_DESCRICAO + " TEXT, " +
                COLUMN_DATA_LANCAMENTO + " TEXT, " +
                COLUMN_DISTRIBUIDORA + " TEXT, " +
                COLUMN_EDITORA + " TEXT, " +
                COLUMN_TRAILER + " TEXT, " +
                COLUMN_FRANQUIA + " TEXT, " +
                COLUMN_DESEJADOS + " INTEGER, " +
                COLUMN_REVIEWS + " INTEGER, " +
                COLUMN_JOGADOS + " INTEGER, " +
                COLUMN_MEDIA + " REAL, " +
                "tags TEXT, " +
                "generos TEXT, " +
                COLUMN_CAPAS + " TEXT)";
        db.execSQL(createJogosTable);

        String createProdutosTable = "CREATE TABLE " + TABLE_PRODUTOS + " (" +
                COLUMN_ID + " INTEGER PRIMARY KEY , " +
                COLUMN_JOGO_ID + " INTEGER, " +
                COLUMN_PRECO + " REAL, " +
                COLUMN_NOME + " TEXT, " +
                "FOREIGN KEY(" + COLUMN_JOGO_ID + ") REFERENCES " + TABLE_JOGOS + "(" + COLUMN_ID + "))";
        db.execSQL(createProdutosTable);

        String createDesejadosTable = "CREATE TABLE " + TABLE_DESEJADOS + " (" +
                COLUMN_ID + " INTEGER PRIMARY KEY AUTOINCREMENT , " +
                COLUMN_JOGO_ID + " INTEGER, " +
                "FOREIGN KEY(" + COLUMN_JOGO_ID + ") REFERENCES " + TABLE_JOGOS + "(" + COLUMN_ID + "))";
        db.execSQL(createDesejadosTable);

        String createScreenshotsTable = "CREATE TABLE " + TABLE_SCREENSHOTS + " (" +
                COLUMN_ID + " INTEGER PRIMARY KEY AUTOINCREMENT , " +
                COLUMN_JOGO_ID + " INTEGER, " +
                COLUMN_FILENAME + " TEXT, " +
                "FOREIGN KEY(" + COLUMN_JOGO_ID + ") REFERENCES " + TABLE_JOGOS + "(" + COLUMN_ID + "))";
        db.execSQL(createScreenshotsTable);
    }

    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {

    }

    private void adicionarJogoBD(Jogo jogo) {
        ContentValues values = new ContentValues();
        values.put(COLUMN_ID, jogo.getId());
        values.put(COLUMN_NOME, jogo.getNome());
        values.put(COLUMN_DESCRICAO, jogo.getDescricao());
        values.put(COLUMN_DATA_LANCAMENTO, jogo.getDataLancamento());
        values.put(COLUMN_DISTRIBUIDORA, jogo.getDistribuidora());
        values.put(COLUMN_EDITORA, jogo.getEditora());
        values.put(COLUMN_TRAILER, jogo.getTrailer());
        values.put(COLUMN_FRANQUIA, jogo.getFranquia());
        values.put(COLUMN_DESEJADOS, jogo.getDesejados());
        values.put(COLUMN_REVIEWS, jogo.getReviews());
        values.put(COLUMN_JOGADOS, jogo.getJogados());
        values.put(COLUMN_MEDIA, jogo.getMedia());
        values.put("tags", TextUtils.join(",", jogo.getTags()));
        values.put("generos", TextUtils.join(",", jogo.getGeneros()));
        values.put(COLUMN_CAPAS, jogo.getCapas());
        adicionarProdutosBD(jogo.getProdutos(), jogo.getId());
        adicionarScreenshotsBD(jogo.getScreenshots(), jogo.getId());
        this.db.insert(TABLE_JOGOS, null, values);
    }

    private void adicionarJogosBD(ArrayList<Jogo> jogos) {
        for(Jogo jogo : jogos){
            adicionarJogoBD(jogo);
        }
    }

    private void adicionarProdutosBD(List<Jogo.Produto> produtos, int jogoId) {
        if (produtos != null && !produtos.isEmpty()) {
            for (Jogo.Produto produto : produtos) {
                ContentValues values = new ContentValues();
                values.put(COLUMN_JOGO_ID, jogoId);
                values.put(COLUMN_PRECO, produto.getPreco());
                values.put(COLUMN_NOME, produto.getPlataformaNome());
                this.db.insert(TABLE_PRODUTOS, null, values);
            }
        }
    }

    private void adicionarScreenshotsBD(List<String> screenshots, int jogoId) {
        if (screenshots != null && !screenshots.isEmpty()) {
            for (String screenshot : screenshots) {
                ContentValues values = new ContentValues();
                values.put(COLUMN_JOGO_ID, jogoId);
                values.put(COLUMN_FILENAME, screenshot);
                this.db.insert(TABLE_SCREENSHOTS, null, values);
            }
        }
    }

    private ArrayList<String> getScreenshotsByJogoIdBD(int jogoId) {
        List<String> screenshots = new ArrayList<>();
        Cursor cursor = this.db.query(TABLE_SCREENSHOTS,
                new String[]{COLUMN_FILENAME},
                COLUMN_JOGO_ID + " = ?",
                new String[]{String.valueOf(jogoId)},
                null, null, null);

        if (cursor.moveToFirst()) {
            do {
                screenshots.add(cursor.getString(0));
            } while (cursor.moveToNext());
        }
        cursor.close();
        return new ArrayList<>(screenshots);
    }



    public void adicionarJogosDesejadosBD(ArrayList<Jogo> jogosDesejados) {
        adicionarJogosBD(jogosDesejados);
        for(Jogo jogo : jogosDesejados){
            ContentValues values = new ContentValues();
            values.put(COLUMN_JOGO_ID, jogo.getId());
            this.db.insert(TABLE_DESEJADOS, null, values);
        }
    }

    public void adicionarJogoDesejadoBD(Jogo jogo) {
        adicionarJogoBD(jogo);
        ContentValues values = new ContentValues();
        values.put(COLUMN_JOGO_ID, jogo.getId());
        this.db.insert(TABLE_DESEJADOS, null, values);
    }

    public ArrayList<Jogo> getJogosDesejadosBD() {
        ArrayList<Jogo> jogosDesejados = new ArrayList<>();


        Cursor cursor = this.db.query(TABLE_DESEJADOS, new String[]{COLUMN_JOGO_ID}, null, null, null, null, null);
        if(cursor.moveToFirst()){
            do {
                int jogoId = cursor.getInt(0);
                Jogo jogo = getJogoBD(jogoId);
                jogosDesejados.add(jogo);
            } while (cursor.moveToNext());
        }
        cursor.close();
        return jogosDesejados;
    }

    public Jogo getJogoDesejadosBD(int jogoId)
    {
        Cursor cursor = this.db.query(TABLE_DESEJADOS, new String[]{COLUMN_JOGO_ID}, COLUMN_JOGO_ID + " = ?", new String[]{String.valueOf(jogoId)}, null, null, null);
        if(cursor.moveToFirst()){
            return getJogoBD(jogoId);
        }
        cursor.close();
        return null;
    }

    private Jogo getJogoBD(int jogoId) {
        Jogo jogo = null;
        Cursor cursor = this.db.query(TABLE_JOGOS, new String[]{COLUMN_ID, COLUMN_NOME, COLUMN_DESCRICAO, COLUMN_DATA_LANCAMENTO,COLUMN_CAPAS, COLUMN_DISTRIBUIDORA, COLUMN_EDITORA, COLUMN_TRAILER, COLUMN_FRANQUIA, COLUMN_DESEJADOS, COLUMN_REVIEWS, COLUMN_JOGADOS, COLUMN_MEDIA, "tags", "generos"}, COLUMN_ID + " = ?", new String[]{String.valueOf(jogoId)}, null, null, null);
        if(cursor.moveToFirst()){
            String tagsString = cursor.getString(13);
            List<Jogo.Tag> tags = new ArrayList<>();

            if (tagsString != null && !tagsString.isEmpty()) {
                for (String tagName : tagsString.split(",")) {
                    Jogo.Tag tag = new Jogo.Tag(-1,tagName.trim());
                    tags.add(tag);
                }
            }

            String generosString = cursor.getString(14);
            List<Jogo.Genero> generos = new ArrayList<>();
            if (generosString != null && !generosString.isEmpty()) {
                for (String generoName : generosString.split(",")) {
                    Jogo.Genero genero = new Jogo.Genero(-1,generoName.trim());
                    generos.add(genero);
                }
            }

            List<Jogo.Produto> produtos = getProdutosByJogoId(jogoId);
            List<String> screenshots = getScreenshotsByJogoIdBD(jogoId);


            jogo = new Jogo(cursor.getInt(0), // id
                    cursor.getString(1), // nome
                    cursor.getString(2), // descricao
                    cursor.getString(3), // dataLancamento
                    cursor.getString(4), // capas
                    cursor.getString(5), // distribuidora
                    cursor.getString(6), // editora
                    cursor.getString(7), // trailer
                    cursor.getString(8), // franquia
                    cursor.getInt(9), // desejados
                    cursor.getInt(11), // jogados
                    cursor.getDouble(12), // media
                    cursor.getInt(10), // reviews
                    null, // avaliacao
                    null, // atividade
                    produtos, // produtos
                    tags, // tags
                    generos, // generos
                    screenshots, // screenshots
                    0); // reviewId
        }
        cursor.close();
        return jogo;
    }

    private List<Jogo.Produto> getProdutosByJogoId(int jogoId) {
        List<Jogo.Produto> produtos = new ArrayList<>();
        Cursor cursor = this.db.query(TABLE_PRODUTOS,
                new String[]{COLUMN_ID, COLUMN_JOGO_ID, COLUMN_PRECO, COLUMN_NOME},
                COLUMN_JOGO_ID + " = ?",
                new String[]{String.valueOf(jogoId)},
                null, null, null);

        if (cursor.moveToFirst()) {
            do {
                Jogo.Produto produto = new Jogo.Produto(
                        cursor.getInt(0), // id
                        cursor.getString(3), // plataformaNome
                        -1, // plataformaId
                        cursor.getDouble(2), // preco
                        -1, //quantidade
                        cursor.getInt(1) // jogoId
                );
                produtos.add(produto);
            } while (cursor.moveToNext());
        }
        cursor.close();
        return produtos;
    }

    public void removerTabelasBD(){
        this.db.delete(TABLE_JOGOS,null,null);
        this.db.delete(TABLE_DESEJADOS,null,null);
        this.db.delete(TABLE_PRODUTOS,null,null);
        this.db.delete(TABLE_SCREENSHOTS,null,null);
    }





}
