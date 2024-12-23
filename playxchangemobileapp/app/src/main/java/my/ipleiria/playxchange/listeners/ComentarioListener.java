package my.ipleiria.playxchange.listeners;

import my.ipleiria.playxchange.models.Comentario;

public interface ComentarioListener {
    void onRefreshComentario(Comentario comentario);
    void onComentarioAdded();
    void onComentarioRemoved();
    void onComentarioUpdated();
}
