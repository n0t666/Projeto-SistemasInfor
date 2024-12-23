package my.ipleiria.playxchange.utils;

import android.util.Patterns;

public class Rules {

    public static boolean isUsernameValid(String username){
        if(username==null)
            return false;
        return username.length() > Constants.MIN_USERNAME_LENGTH;
    }

    public static boolean isPasswordValid(String password){
        if(password==null)
            return false;
        return password.length() > 4;
    }

    public static boolean isEmailValid(String email){
        if(email==null)
            return false;
        return Patterns.EMAIL_ADDRESS.matcher(email).matches();
    }

    public static boolean isPasswordValidNew(String password){
        return password.length() >= Constants.MIN_PASSWORD_LENGTH;
    }

    public static boolean isNifValid(String nif){
        return nif.length() == Constants.NIF_LENGTH && nif.matches("[0-9]+"); // 9 digítos e apenas números
    }

    public static boolean isBiografiaValid(String biografia){
        return biografia.length() <= Constants.MAX_BIO_LENGTH;
    }

    public static boolean isNomeValid(String nome){
        if(nome==null)
            return false;
        return nome.length() <= Constants.MAX_NAME_LENGTH;
    }

    public static boolean isPrivacidadeValid(int privacidade){
        return privacidade == Constants.PRIVACY_PUBLIC || privacidade == Constants.PRIVACY_FRIENDS || privacidade == Constants.PRIVACY_PRIVATE;
    }

    public static boolean isComentarioValid(String comentario){
        return comentario.length() <= Constants.MAX_COMMENT_LENGTH;
    }
}
