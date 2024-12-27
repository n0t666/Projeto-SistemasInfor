package my.ipleiria.playxchange.adapters;

import android.content.Context;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.RatingBar;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.google.android.material.button.MaterialButton;
import com.google.android.material.textview.MaterialTextView;

import java.util.ArrayList;

import my.ipleiria.playxchange.ComentarioDetailsActivity;
import my.ipleiria.playxchange.R;
import my.ipleiria.playxchange.models.Comentario;
import my.ipleiria.playxchange.models.SingletonLoja;
import my.ipleiria.playxchange.utils.Constants;

public class ComentariosAdapter extends BaseAdapter {

    private Context context;
    private LayoutInflater inflater;
    private ArrayList<Comentario> comentarios;

    public ComentariosAdapter(Context context, ArrayList<Comentario> comentarios) {
        this.context = context;
        this.comentarios = comentarios;
    }

    @Override
    public int getCount() {
        return comentarios.size();
    }

    @Override
    public Object getItem(int position) {
        return comentarios.get(position);
    }

    @Override
    public long getItemId(int position) {
        return comentarios.get(position).getId();
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        if(inflater == null){
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        }

        if(convertView == null){
            convertView = inflater.inflate(R.layout.comentario_item, null);
        }

        ComentariosAdapter.ViewHolderList viewHolder = (ComentariosAdapter.ViewHolderList) convertView.getTag();
        if (viewHolder == null){
            viewHolder = new ComentariosAdapter.ViewHolderList(convertView);
            convertView.setTag(viewHolder);
        }

        viewHolder.update(comentarios.get(position));
        return convertView;
    }

    private class ViewHolderList {

        private MaterialTextView tvJogoNome,tvComentario;

        private ImageView ivCapa;

        private RatingBar rbEstrelas;

        private MaterialButton btnVerMais;

        public ViewHolderList(View view){
            tvJogoNome = view.findViewById(R.id.tvJogoNome);
            tvComentario = view.findViewById(R.id.tvComentario);
            ivCapa = view.findViewById(R.id.ivCapa);
            rbEstrelas = view.findViewById(R.id.rbEstrelas);
            btnVerMais = view.findViewById(R.id.btnVer);
        }

        public void update(Comentario comentario){
            tvJogoNome.setText(comentario.getJogo().getNome());
            tvComentario.setText(comentario.getComentario());
            Glide.with(context)
                    .load(comentario.getJogo().getCapas())
                    .placeholder(R.drawable.placeholder_jogo)
                    .diskCacheStrategy(DiskCacheStrategy.ALL)
                    .into(ivCapa);
            rbEstrelas.setRating((float)comentario.getNumEstrelas());
            btnVerMais.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    int id = comentario.getJogo().getId();
                    Intent intent = new Intent(context, ComentarioDetailsActivity.class);
                    intent.putExtra("ID_COMENTARIO", id);
                    intent.putExtra("REQUEST_CODE", Constants.REQUEST_CODE_EDIT_COMMENT);
                    context.startActivity(intent);
                }
            });
        }
    }
}
