package my.ipleiria.playxchange.models;

import android.content.Context;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

import androidx.annotation.Nullable;

public class LojaBDHelper extends SQLiteOpenHelper
{
    private static final String DB_NAME= "bdLoja";

    //Tables


    //Columns
    private static final String ID="id",NOME="nome",MORADA="morada",TELEFONE="telefone",EMAIL="email",HORARIO="horario",IMAGEM="imagem";
    private final SQLiteDatabase db;

    public LojaBDHelper(@Nullable Context context) {
        super(context, DB_NAME, null, 1);
        this.db = getWritableDatabase();
    }

    @Override
    public void onCreate(SQLiteDatabase db) {

    }

    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {

    }
}
