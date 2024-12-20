package my.ipleiria.playxchange.listeners;

import java.util.ArrayList;

import my.ipleiria.playxchange.models.Comentario;

public interface ComentariosListener {
    void onRefreshComentarios(ArrayList<Comentario>comentarios);
}
